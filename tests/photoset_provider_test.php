<?php
// Regression: Der Provider für die FotoSetCard-Erstellung ist der von BKI für
// Projekt 23 dokumentierte technische Identifier. Seine Schreibweise darf weder
// an einen Anzeigenamen noch an eine vermeintliche Normalisierung angepasst werden.
$source = file_get_contents(dirname(__DIR__) . '/public/api.php');
$documentedProvider = 'Browsercloud';

$start = strpos($source, "if (\$action === 'start_photoset')");
$end = strpos($source, "if (\$action === 'poll_photoset')", $start);
if ($start === false || $end === false) {
    throw new Exception('Der FotoSet-Start-Workflow wurde nicht gefunden.');
}

$startPhotoSet = substr($source, $start, $end - $start);
$pattern = "/->startRun\\(\\s*app_config\\('project_photoset',\\s*23\\),.*?'([^']+)'\\s*,/s";
if (!preg_match($pattern, $startPhotoSet, $providerMatch)) {
    throw new Exception('Der an BkiClient::startRun() übergebene FotoSet-Provider wurde nicht gefunden.');
}
if ($providerMatch[1] !== $documentedProvider) {
    throw new Exception('Falscher Projekt-23-Provider: erwartet ' . $documentedProvider . ', erhalten ' . $providerMatch[1] . '.');
}

// Zusätzlich den vollständigen von BkiClient erzeugten Run-Payload prüfen.
// So fällt auch eine spätere Umwandlung zwischen Handler und HTTP-Aufruf auf.
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
$client->startRun(23, $providerMatch[1], array(), 'test-draft', array('section_texts' => array()));
if (!isset($client->recordedBody['provider']) || $client->recordedBody['provider'] !== $documentedProvider) {
    throw new Exception('Der vollständige Run-Payload enthält nicht den dokumentierten technischen Provider-Identifier.');
}

echo "OK: BkiClient::startRun() erhält für Projekt 23 exakt Browsercloud.\n";
