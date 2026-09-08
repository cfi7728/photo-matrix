<?php
// Regressionstest: Upload-Aktionen adressieren Bilder stabil und nicht über ihre Position.
$source = file_get_contents(dirname(__DIR__) . '/public/api.php');

function load_upload_function($source, $name) {
    $start = strpos($source, 'function ' . $name . '(');
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

foreach (array('ensure_upload_ids', 'hash_equals_compat', 'find_upload_index') as $function) {
    load_upload_function($source, $function);
}

$uploads = array(
    array('id' => 'first', 'path' => '/tmp/first.jpg'),
    array('id' => 'middle', 'path' => '/tmp/middle.jpg'),
    array('id' => 'last', 'path' => '/tmp/last.jpg')
);
if (find_upload_index($uploads, 'middle') !== 1) throw new Exception('Das mittlere Bild wurde nicht gefunden.');
array_splice($uploads, find_upload_index($uploads, 'middle'), 1);
if (count($uploads) !== 2 || $uploads[0]['id'] !== 'first' || $uploads[1]['id'] !== 'last') {
    throw new Exception('Es wurde nicht exakt das gewählte Bild entfernt.');
}

$legacy = ensure_upload_ids(array(array('path' => '/tmp/legacy.jpg')));
if (!isset($legacy[0]['id']) || find_upload_index($legacy, $legacy[0]['id']) !== 0) {
    throw new Exception('Bestehende Uploads erhalten keine stabile ID.');
}

echo "OK: Tauschen und Löschen adressieren das gewählte Bild über eine stabile ID.\n";
