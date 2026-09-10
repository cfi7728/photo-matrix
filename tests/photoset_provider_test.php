<?php
// Regression: Der Provider für die FotoSetCard-Erstellung ist eine feste
// Workflow-Vorgabe und darf nicht versehentlich über die Konfiguration wechseln.
$source = file_get_contents(dirname(__DIR__) . '/public/api.php');

$start = strpos($source, "if (\$action === 'start_photoset')");
$end = strpos($source, "if (\$action === 'poll_photoset')", $start);
if ($start === false || $end === false) {
    throw new Exception('Der FotoSet-Start-Workflow wurde nicht gefunden.');
}

$startPhotoSet = substr($source, $start, $end - $start);
if (strpos($startPhotoSet, "'browsercloud'") === false) {
    throw new Exception('FotoSetCards werden nicht mit browsercloud gestartet.');
}
if (strpos($startPhotoSet, "app_config('provider_photoset'") !== false) {
    throw new Exception('Der FotoSet-Provider darf nicht konfigurierbar sein.');
}
if (preg_match('/browsercloud/i', $startPhotoSet, $providerMatch) && $providerMatch[0] !== 'browsercloud') {
    throw new Exception('Der Providername muss durchgehend kleingeschrieben werden: browsercloud.');
}

echo "OK: FotoSetCards werden fest mit browsercloud gestartet.\n";
