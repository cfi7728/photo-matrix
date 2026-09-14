<?php
// Regression: Projekt 23 verwendet standardmäßig den technischen BKI-Identifier
// "browsercloud", erlaubt aber installationsspezifische, nicht leere Overrides.
$configPath = dirname(__DIR__) . '/app/config.php';
$previousProvider = getenv('BKI_PHOTOSET_PROVIDER');

putenv('BKI_PHOTOSET_PROVIDER');
$defaultConfig = require $configPath;
if ($defaultConfig['provider_photoset'] !== 'browsercloud') {
    throw new Exception('Der Standard-Provider für Projekt 23 ist nicht browsercloud.');
}

putenv('BKI_PHOTOSET_PROVIDER=custom-provider');
$overrideConfig = require $configPath;
if ($overrideConfig['provider_photoset'] !== 'custom-provider') {
    throw new Exception('BKI_PHOTOSET_PROVIDER wird nicht als Override übernommen.');
}

putenv('BKI_PHOTOSET_PROVIDER=   ');
$emptyConfig = require $configPath;
if ($emptyConfig['provider_photoset'] !== 'browsercloud') {
    throw new Exception('Ein leerer BKI_PHOTOSET_PROVIDER muss auf browsercloud zurückfallen.');
}

if ($previousProvider === false) {
    putenv('BKI_PHOTOSET_PROVIDER');
} else {
    putenv('BKI_PHOTOSET_PROVIDER=' . $previousProvider);
}

$source = file_get_contents(dirname(__DIR__) . '/public/api.php');
$start = strpos($source, "if (\$action === 'start_photoset')");
$end = strpos($source, "if (\$action === 'poll_photoset')", $start);
if ($start === false || $end === false) {
    throw new Exception('Der FotoSet-Start-Workflow wurde nicht gefunden.');
}
$startPhotoSet = substr($source, $start, $end - $start);
if (strpos($startPhotoSet, "app_config('provider_photoset', 'browsercloud')") === false) {
    throw new Exception('Der FotoSet-Handler verwendet nicht den konfigurierten Provider mit technischem Standardwert.');
}

// Den vollständigen von BkiClient erzeugten Run-Payload für Standard und Override
// prüfen, damit auch spätere Umwandlungen vor dem HTTP-Aufruf auffallen.
if (!function_exists('uuid_v4_compat')) {
    function uuid_v4_compat() {
        return '00000000-0000-4000-8000-000000000000';
    }
}
require_once dirname(__DIR__) . '/app/lib/BkiClient.php';

class RecordingBkiClient extends BkiClient {
    public $recordedBody;

    public function __construct() {
        parent::__construct('http://example.invalid', 'test-key', false);
    }

    public function post($path, $body, $idempotencyKey) {
        $this->recordedBody = $body;
        return array('run_id' => 'test-run');
    }
}

$client = new RecordingBkiClient();
foreach (array($defaultConfig['provider_photoset'], $overrideConfig['provider_photoset']) as $provider) {
    $client->startRun(23, $provider, array(), 'test-draft', array('section_texts' => array()));
    if (!isset($client->recordedBody['provider']) || $client->recordedBody['provider'] !== $provider) {
        throw new Exception('Der vollständige Run-Payload enthält nicht den erwarteten technischen Provider-Identifier.');
    }
}

echo "OK: Projekt 23 sendet browsercloud als Standard und unterstützt einen Provider-Override.\n";
