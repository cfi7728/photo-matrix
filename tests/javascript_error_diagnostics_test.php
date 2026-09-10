<?php
// Regression: Fehler der FotoSet-Generierung müssen in den Browser-DevTools
// genug Kontext zur Diagnose liefern, auch wenn poll_photoset mit HTTP 200 und
// ok=false antwortet oder der Webserver kein JSON zurückgibt.
$source = file_get_contents(dirname(__DIR__) . '/public/assets/app.js');

$required = array(
    "consoleErrorDetails(action",
    "httpStatus:r.status",
    "durationMs:Date.now()-started",
    "response:j||body.slice(0,4000)",
    "parseError:parseError",
    "generationFailure('poll_photoset',r"
);

foreach ($required as $needle) {
    if (strpos($source, $needle) === false) {
        throw new Exception('JavaScript-Fehlerdiagnose fehlt: ' . $needle);
    }
}

echo "OK: FotoSet-Fehler enthalten detaillierte JavaScript-Konsolendiagnosen.\n";
