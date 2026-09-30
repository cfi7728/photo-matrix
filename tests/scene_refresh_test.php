<?php
$api = file_get_contents(dirname(__DIR__) . '/public/api.php');
$js = file_get_contents(dirname(__DIR__) . '/public/assets/app.js');
$client = file_get_contents(dirname(__DIR__) . '/app/lib/BkiClient.php');

if (strpos($api, "if (\$action === 'refresh_scenes')") === false) {
    throw new Exception('Der API-Endpunkt zum Aktualisieren der Szenen fehlt.');
}
if (strpos($js, "api('refresh_scenes')") === false) {
    throw new Exception('Die UI aktualisiert Szenen nicht vor der Anzeige über die API.');
}
if (strpos($js, "back-scenes').onclick=function(){refreshScenesAndShow()") === false) {
    throw new Exception('Die Rückkehr zur Szenenauswahl aktualisiert die API-Daten nicht.');
}
if (substr_count($client, '_fresh=') < 3) {
    throw new Exception('Katalogabrufe besitzen keinen Cache-Buster für den aktuellen Projektstand.');
}

echo "OK: Szenen werden vor der Anzeige frisch über die API geladen.\n";
