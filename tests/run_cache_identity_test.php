<?php
// Regression: Wird eine externe run_id erneut vergeben, müssen Polling und
// Ressourcenabruf durch die lokale Generation voneinander getrennt bleiben.
require_once dirname(__DIR__) . '/app/lib/BkiClient.php';

class RecordingBkiClient extends BkiClient {
    public $paths = array();

    public function __construct() {}

    public function get($path) {
        $this->paths[] = $path;
        return array('path' => $path);
    }
}

$client = new RecordingBkiClient();
$client->getRun('duplicate/run', 'attempt 1');
$client->getRun('duplicate/run', 'attempt 4');

if ($client->paths[0] === $client->paths[1]) {
    throw new Exception('Zwei lokale Generationen verwenden dieselbe cachebare Run-URL.');
}
if ($client->paths[0] !== '/runs/duplicate%2Frun?cache_key=attempt%201') {
    throw new Exception('run_id oder generation_key werden nicht sicher URL-kodiert.');
}
if ($client->paths[1] !== '/runs/duplicate%2Frun?cache_key=attempt%204') {
    throw new Exception('Die neue lokale Generation fehlt in der Run-URL.');
}

echo "OK: Wiedervergebene run_ids werden pro lokaler Generation cache-sicher abgefragt.\n";
