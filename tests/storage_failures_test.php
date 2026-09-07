<?php
// Kleine, frameworkfreie Regressionstests; lauffähig mit allen unterstützten PHP-Versionen.
$source = file_get_contents(dirname(__DIR__) . '/public/api.php');

function load_api_function($source, $name) {
    $needle = 'function ' . $name . '(';
    $start = strpos($source, $needle);
    if ($start === false) throw new Exception('Funktion nicht gefunden: ' . $name);
    $brace = strpos($source, '{', $start);
    $depth = 0;
    $length = strlen($source);
    for ($i = $brace; $i < $length; $i++) {
        if ($source[$i] === '{') $depth++;
        else if ($source[$i] === '}' && --$depth === 0) {
            eval(substr($source, $start, $i - $start + 1));
            return;
        }
    }
    throw new Exception('Funktionsende nicht gefunden: ' . $name);
}

foreach (array('materialize_ref_to_file', 'valid_saved_files', 'photoset_library_base', 'archive_photoset_files') as $function) {
    load_api_function($source, $function);
}

$testStorage = sys_get_temp_dir() . '/photo-matrix-test-' . uniqid();
function app_config($key, $default = null) {
    global $testStorage;
    return $key === 'storage' ? $testStorage : $default;
}
function expect_exception($label, $callback, $pathFragment) {
    try {
        $callback();
    } catch (Exception $e) {
        if (strpos($e->getMessage(), $pathFragment) === false) throw new Exception($label . ': Zielpfad fehlt in Exception: ' . $e->getMessage());
        echo "OK: $label\n";
        return;
    }
    throw new Exception($label . ': Exception wurde nicht ausgelöst.');
}

class FailingDownloadClient {
    function downloadRunResource($runId, $fileId) { throw new Exception('Run-Download fehlgeschlagen'); }
    function downloadFile($fileId) { throw new Exception('Bilddownload fehlgeschlagen'); }
}
expect_exception('fehlgeschlagener Bilddownload', function () {
    materialize_ref_to_file(new FailingDownloadClient(), 'run-1', array('type' => 'file', 'file_id' => 'file-1'), '/tmp/result');
}, 'Bilddownload fehlgeschlagen');

class ByteClient {}
expect_exception('nicht beschreibbares Materialisierungsziel', function () {
    materialize_ref_to_file(new ByteClient(), null, array('type' => 'base64', 'data' => base64_encode(str_repeat('x', 200))), '/proc/photo-matrix-unwritable/result');
}, '/proc/photo-matrix-unwritable/result.png');

$sourceFile = tempnam(sys_get_temp_dir(), 'photo-matrix-source-');
file_put_contents($sourceFile, str_repeat('image', 100));
$testStorage = '/proc/photo-matrix-unwritable';
expect_exception('nicht beschreibbares Archiv-Storage', function () use ($sourceFile) {
    archive_photoset_files(array($sourceFile), array('run_id' => 'unwritable'));
}, 'FotoSet-Bibliothek');

$testStorage = sys_get_temp_dir() . '/photo-matrix-test-' . uniqid();
$libraryId = 'ps-' . substr(sha1('run|meta-failure'), 0, 24);
$libraryDir = $testStorage . '/photoset-library/' . $libraryId;
mkdir($libraryDir . '/meta.json', 0775, true);
expect_exception('fehlgeschlagenes Schreiben von meta.json', function () use ($sourceFile) {
    archive_photoset_files(array($sourceFile), array('run_id' => 'meta-failure'));
}, $libraryDir . '/meta.json');

unlink($sourceFile);
echo "Alle Storage-Fehlerfälle bestanden.\n";
