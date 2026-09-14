<?php
// Regression: Fehler der FotoSet-Generierung müssen in den Browser-DevTools
// genug Kontext zur Diagnose liefern, auch wenn poll_photoset mit HTTP 200 und
// ok=false antwortet oder der Webserver kein JSON zurückgibt.
$source = file_get_contents(dirname(__DIR__) . '/public/assets/app.js');
$apiSource = file_get_contents(dirname(__DIR__) . '/public/api.php');

$required = array(
    "consoleErrorDetails(action",
    "httpStatus:r.status",
    "durationMs:Date.now()-started",
    "response:j||body.slice(0,4000)",
    "parseError:parseError",
    "runId:response&&response.run_id",
    "generationFailure('poll_photoset',r"
);

foreach ($required as $needle) {
    if (strpos($source, $needle) === false) {
        throw new Exception('JavaScript-Fehlerdiagnose fehlt: ' . $needle);
    }
}

$pollStart = strpos($apiSource, "if (\$action === 'poll_photoset')");
$pollEnd = strpos($apiSource, "if (\$action === 'diagnose_photoset_run')", $pollStart);
if ($pollStart === false || $pollEnd === false) {
    throw new Exception('Der FotoSet-Polling-Handler wurde nicht gefunden.');
}
$pollHandler = substr($apiSource, $pollStart, $pollEnd - $pollStart);
$failureStart = strpos($pollHandler, "if (\$status === 'failed' || \$status === 'error' || \$status === 'cancelled' || \$status === 'canceled')");
$failureEnd = strpos($pollHandler, "json_response(array('ok' => true", $failureStart);
if ($failureStart === false || $failureEnd === false) {
    throw new Exception('Der Fehlerzweig des FotoSet-Polling-Handlers wurde nicht gefunden.');
}
$failureHandler = substr($pollHandler, $failureStart, $failureEnd - $failureStart);
foreach (array(
    "'run_id' => \$runId",
    "'diagnostics' => array(",
    "'run_shape' => diagnostic_structure(\$run, 0)",
    "\$failure['attempt_id'] = \$attemptId",
    "\$failure['photoset_generation_id'] = \$generationId"
) as $needle) {
    if (strpos($failureHandler, $needle) === false) {
        throw new Exception('Diagnosekontext im fehlgeschlagenen FotoSet-Response fehlt: ' . $needle);
    }
}

echo "OK: FotoSet-Fehler enthalten detaillierte JavaScript-Konsolendiagnosen.\n";
