<?php
// Isolierter Regressionstest: api.php selbst darf wegen seines Request-Dispatchers
// nicht eingebunden werden, daher werden nur die getesteten Funktionen geladen.
$source = file_get_contents(dirname(__DIR__) . '/public/api.php');

function load_run_error_function($source, $name) {
    $start = strpos($source, 'function ' . $name . '(');
    if ($start === false) throw new Exception('Funktion nicht gefunden: ' . $name);
    $brace = strpos($source, '{', $start);
    $depth = 0;
    $quote = null;
    $escaped = false;
    for ($i = $brace, $length = strlen($source); $i < $length; $i++) {
        if ($quote !== null) {
            if ($escaped) { $escaped = false; continue; }
            if ($source[$i] === '\\') { $escaped = true; continue; }
            if ($source[$i] === $quote) $quote = null;
            continue;
        }
        if ($source[$i] === "'" || $source[$i] === '"') { $quote = $source[$i]; continue; }
        if ($source[$i] === '{') $depth++;
        else if ($source[$i] === '}' && --$depth === 0) {
            eval(substr($source, $start, $i - $start + 1));
            return;
        }
    }
    throw new Exception('Funktionsende nicht gefunden: ' . $name);
}

foreach (array('sanitize_run_error_value', 'collect_run_error_values', 'run_error_message') as $function) {
    load_run_error_function($source, $function);
}

$cases = array(
    'data.error.message' => array(array('data' => array('error' => array('message' => 'Direkter BKI-Fehler'))), 'Direkter BKI-Fehler'),
    'verschachtelte Provider-Meldung' => array(array('data' => array('result' => array('provider_response' => array('error' => array('message' => 'Provider nicht erreichbar'))))), 'Provider nicht erreichbar'),
    'JSON-kodierte Provider-Antwort' => array(array('data' => array('provider_result' => '{"response":{"error":{"message":"JSON-Providerfehler"}}}')), 'JSON-Providerfehler'),
    'Fehlerliste' => array(array('data' => array('errors' => array(array('detail' => 'Bildformat ungültig'), array('reason' => 'Datei beschädigt')))), 'Bildformat ungültig | Datei beschädigt'),
    'generischer Fallback' => array(array('data' => array('status' => 'failed', 'provider_response' => array('prompt_text' => 'vertraulicher Prompt'))), 'Generierung fehlgeschlagen.')
);

foreach ($cases as $label => $case) {
    $actual = run_error_message($case[0]);
    if ($actual !== $case[1]) throw new Exception($label . ': erwartet "' . $case[1] . '", erhalten "' . $actual . '".');
}

// Explizite messages gewinnen gegen Details; sensible Inhalte werden nie geleakt.
$safe = run_error_message(array('error' => array('detail' => 'Nebeninfo', 'message' => 'Fehler mit api_key=topsecret')));
if ($safe !== 'Fehler mit api_key=[REDACTED]') throw new Exception('Priorisierung oder Secret-Redaktion fehlgeschlagen: ' . $safe);
$base64 = run_error_message(array('errors' => array('data:image/png;base64,' . str_repeat('A', 300))));
if ($base64 !== 'Generierung fehlgeschlagen.') throw new Exception('Base64-Daten wurden ausgegeben.');
$prompt = run_error_message(array('error' => array('message' => 'Prompt: geheime Eingabe')));
if ($prompt !== 'Generierung fehlgeschlagen.') throw new Exception('Prompttext wurde ausgegeben.');

echo "OK: Verschachtelte BKI-Run-Fehler werden sicher ausgewertet.\n";
