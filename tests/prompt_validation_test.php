<?php
if (!function_exists('uuid_v4_compat')) {
    function uuid_v4_compat() { return 'test-uuid'; }
}
require_once dirname(__DIR__) . '/app/lib/BkiClient.php';
require_once dirname(__DIR__) . '/app/lib/PromptValidation.php';

function prompt_assert($condition, $message) {
    if (!$condition) throw new Exception($message);
}

class PromptRecordingClient extends BkiClient {
    public $calls = array();
    public function __construct() {}
    public function post($path, $body, $idempotencyKey) {
        $this->calls[] = array($path, $body, $idempotencyKey);
        return array('data' => array('prompt' => array('valid' => true)));
    }
}

$client = new PromptRecordingClient();
$client->resolvePrompt(23, array('provider' => 'browsercloud'));
prompt_assert($client->calls[0][0] === '/projects/23/prompt/resolve', 'Falscher Resolve-Endpunkt.');
prompt_assert($client->calls[0][2] === null, 'Prompt-Resolve darf keinen Idempotency-Key senden.');

$details = BkiClient::validationErrorDetails(array('detail' => array(array(
    'parameter' => 'values.2885',
    'code' => 'invalid_type',
    'expected_type' => 'string',
    'message' => "Ungültiger\nWert"
))));
prompt_assert(count($details) === 1, 'Die HTTP-422-Details wurden nicht erkannt.');
foreach (array('parameter=values.2885', 'code=invalid_type', 'expected_type=string', 'message=Ungültiger Wert') as $part) {
    prompt_assert(strpos($details[0], $part) !== false, 'HTTP-422-Feld fehlt: ' . $part);
}
prompt_assert(strpos($details[0], "\n") === false, 'Diagnosewerte wurden nicht sanitisiert.');

$api = file_get_contents(dirname(__DIR__) . '/public/api.php');
$photosetStart = strpos($api, "if (\$action === 'start_photoset')");
$photosetEnd = strpos($api, "if (\$action === 'poll_photoset')", $photosetStart);
$photoset = substr($api, $photosetStart, $photosetEnd - $photosetStart);
prompt_assert(strpos($photoset, 'resolvePrompt(') < strpos($photoset, 'startRun('), 'Projekt 23 startet /runs vor der Promptprüfung.');
prompt_assert(strpos($photoset, 'PromptValidation::assertValid') !== false, 'Projekt 23 wertet valid=false nicht aus.');

$scenesStart = strpos($api, "if (\$action === 'start_scenes')");
$scenesEnd = strpos($api, "if (\$action === 'poll_scenes')", $scenesStart);
$sceneBlock = substr($api, $scenesStart, $scenesEnd - $scenesStart);
$resolve = strpos($sceneBlock, 'resolvePrompt(');
$run = strpos($sceneBlock, 'startRun(');
prompt_assert($resolve !== false && $resolve < $run, 'Projekt 18 startet /runs vor der Promptprüfung.');
prompt_assert(strpos($sceneBlock, '$sceneValues[]') < $run, 'Die drei Szenen werden nicht vor dem ersten /runs-Aufruf vollständig geprüft.');
prompt_assert(strpos($sceneBlock, "\$values[(string)\$bindings['scene']] = \$scene") < $resolve, 'Die Szene fehlt im geprüften vollständigen Werte-Satz.');

// Den produktiven Guard im selben Kontrollfluss wie einen Run-Aufruf ausführen.
$runCalls = 0;
$invalid = array('data' => array('prompt' => array('valid' => false, 'errors' => array(array('message' => 'Pflichtfeld fehlt')))));
try {
    PromptValidation::assertValid($invalid, 'Testszenario');
    $runCalls++;
} catch (Exception $e) {
    prompt_assert(strpos($e->getMessage(), 'message=Pflichtfeld fehlt') !== false, 'Promptfehler wird nicht verständlich ausgegeben.');
}
prompt_assert($runCalls === 0, 'Bei valid=false wurde /runs aufgerufen.');

echo "OK: Promptprüfung erfolgt vor allen Runs; valid=false verhindert /runs und 422-Details bleiben sanitisiert sichtbar.\n";
