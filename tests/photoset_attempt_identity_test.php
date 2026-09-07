<?php
// Regression: Zwei lokale Generierungen dürfen bei identischer BKI-run_id
// weder dieselbe Session-Card noch denselben Bibliotheks-Snapshot verwenden.
$source = file_get_contents(dirname(__DIR__) . '/public/api.php');

function load_api_function($source, $name) {
    $needle = 'function ' . $name . '(';
    $start = strpos($source, $needle);
    if ($start === false) throw new Exception('Funktion nicht gefunden: ' . $name);
    $brace = strpos($source, '{', $start);
    $depth = 0;
    for ($i = $brace, $length = strlen($source); $i < $length; $i++) {
        if ($source[$i] === '{') $depth++;
        else if ($source[$i] === '}' && --$depth === 0) {
            eval(substr($source, $start, $i - $start + 1));
            return;
        }
    }
    throw new Exception('Funktionsende nicht gefunden: ' . $name);
}

foreach (array(
    'begin_photoset_attempt', 'bind_photoset_attempt_run', 'store_photoset_attempt',
    'photoset_storage_error', 'valid_saved_files', 'storage_session_dir',
    'materialize_ref_to_file', 'materialize_photoset_attempt',
    'photoset_library_base', 'archive_photoset_files'
) as $function) load_api_function($source, $function);

$testStorage = sys_get_temp_dir() . '/photo-matrix-identity-' . uniqid();
$uuidCounter = 0;
function app_config($key, $default = null) {
    global $testStorage;
    return $key === 'storage' ? $testStorage : $default;
}
function uuid_v4_compat() {
    global $uuidCounter;
    return 'generation-' . (++$uuidCounter);
}

class TestFlow {
    private $state = array('photoset_attempts' => array());
    function get($key, $default) { return isset($this->state[$key]) ? $this->state[$key] : $default; }
    function set($key, $value) { $this->state[$key] = $value; }
}
class TestClient {}

$flow = new TestFlow();
$image = array('type' => 'base64', 'mime' => 'image/png', 'data' => base64_encode(str_repeat('image-bytes-', 20)));

$first = begin_photoset_attempt($flow, 'draft-a');
bind_photoset_attempt_run($flow, $first['id'], 'duplicate-run');
$firstStored = store_photoset_attempt(new TestClient(), $flow, 'duplicate-run', array($image), $first['id']);

$second = begin_photoset_attempt($flow, 'draft-b');
bind_photoset_attempt_run($flow, $second['id'], 'duplicate-run');
$secondStored = store_photoset_attempt(new TestClient(), $flow, 'duplicate-run', array($image), $second['id']);

if ($firstStored['id'] === $secondStored['id']) throw new Exception('Identische run_id hat dieselbe Card wiederverwendet.');
if ($firstStored['library_id'] === $secondStored['library_id']) throw new Exception('Identische run_id hat denselben Snapshot wiederverwendet.');
if (empty($firstStored['_card_created']) || empty($secondStored['_card_created'])) throw new Exception('Neue lokale Durchläufe wurden nicht als neue Cards gemeldet.');

$secondPoll = store_photoset_attempt(new TestClient(), $flow, 'duplicate-run', array($image), $second['id']);
if (empty($secondPoll['_card_reused']) || !empty($secondPoll['_card_created'])) throw new Exception('Erneutes Polling wurde nicht als Card-Wiederverwendung gemeldet.');

echo "OK: identische externe run_id erzeugt pro lokaler Generierung einen eigenen Snapshot.\n";
