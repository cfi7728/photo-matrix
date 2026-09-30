<?php
require_once dirname(__DIR__) . '/app/lib/FieldCatalog.php';

$catalog = new FieldCatalog(array('data' => array('providers' => array(
    array('technical_id' => 'vehabi', 'name' => 'Vehabi'),
    array('identifier' => 'alternative', 'name' => 'Alternative')
))), array(), array());
if ($catalog->resolveProvider('vehabi', 'Projekt 18', 'BKI_SCENE_PROVIDER') !== 'vehabi') throw new Exception('Die gültige Szenen-Präferenz wird nicht übernommen.');
try {
    $catalog->resolveProvider('missing', 'Projekt 18', 'BKI_SCENE_PROVIDER');
    throw new Exception('Ein unbekannter Szenen-Provider wurde akzeptiert.');
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'BKI_SCENE_PROVIDER') === false || strpos($e->getMessage(), 'vehabi') === false) throw $e;
}

$previous = getenv('BKI_SCENE_PROVIDER');
putenv('BKI_SCENE_PROVIDER');
$config = require dirname(__DIR__) . '/app/config.php';
if ($config['provider_scene'] !== 'vehabi') throw new Exception('BKI_SCENE_PROVIDER muss standardmäßig vehabi verwenden.');
putenv('BKI_SCENE_PROVIDER=   ');
$config = require dirname(__DIR__) . '/app/config.php';
if ($config['provider_scene'] !== 'vehabi') throw new Exception('Ein leerer BKI_SCENE_PROVIDER muss auf vehabi zurückfallen.');
putenv('BKI_SCENE_PROVIDER=alternative');
$config = require dirname(__DIR__) . '/app/config.php';
if ($config['provider_scene'] !== 'alternative') throw new Exception('BKI_SCENE_PROVIDER wird nicht als Präferenz übernommen.');
$previous === false ? putenv('BKI_SCENE_PROVIDER') : putenv('BKI_SCENE_PROVIDER=' . $previous);

$source = file_get_contents(dirname(__DIR__) . '/public/api.php');
$start = strpos($source, "if (\$action === 'start_scenes')");
$end = strpos($source, "if (\$action === 'poll_scenes')", $start);
$block = substr($source, $start, $end - $start);
if (strpos($block, 'BKI_SCENE_PROVIDER') === false || strpos($block, 'resolveProvider(') === false) throw new Exception('Projekt 18 löst den Provider nicht gegen die aktuelle Workbench auf.');
if (strpos($block, 'PromptValidation::payload($sceneProvider') === false || strpos($block, '$sceneProvider,') === false) throw new Exception('Der aufgelöste Szenen-Provider wird nicht unverändert für Resolve und Run genutzt.');

echo "OK: Projekt 18 wählt ausschließlich einen Provider der aktuellen Workbench.\n";
