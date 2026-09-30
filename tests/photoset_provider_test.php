<?php
require_once dirname(__DIR__) . '/app/lib/FieldCatalog.php';

function provider_assert_same($expected, $actual, $message) {
    if ($expected !== $actual) throw new Exception($message . '\nErwartet: ' . json_encode($expected) . '\nErhalten: ' . json_encode($actual));
}

$catalog = new FieldCatalog(array('data' => array('providers' => array(
    array('id' => 'browsercloud', 'name' => 'Browser Cloud'),
    array('provider_id' => 'second-provider', 'label' => 'Zweiter Provider'),
    array('id' => 'browsercloud')
))), array(), array());
provider_assert_same(array('browsercloud', 'second-provider'), $catalog->providerIds(), 'Technische Provider-IDs werden nicht normalisiert aus data.providers gelesen.');
$mapped = new FieldCatalog(array('data' => array('providers' => array('mapped-provider' => 'Lesbarer Anzeigename'))), array(), array());
provider_assert_same(array('mapped-provider'), $mapped->providerIds(), 'Bei einer Provider-Map wird der Anzeigename statt der technischen Schlüssel-ID verwendet.');
provider_assert_same('browsercloud', $catalog->resolveProvider('browsercloud', 'Projekt 23', 'BKI_PHOTOSET_PROVIDER'), 'Die gültige FotoSet-Präferenz wird nicht übernommen.');

try {
    $catalog->resolveProvider('unknown', 'Projekt 23', 'BKI_PHOTOSET_PROVIDER');
    throw new Exception('Ein unbekannter FotoSet-Provider wurde akzeptiert.');
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'unbekannten Provider') === false || strpos($e->getMessage(), 'browsercloud') === false) throw $e;
}
try {
    $catalog->resolveProvider('', 'Projekt 23', 'BKI_PHOTOSET_PROVIDER');
    throw new Exception('Bei mehreren Providern wurde ohne Präferenz geraten.');
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'mehrere Provider') === false || strpos($e->getMessage(), 'BKI_PHOTOSET_PROVIDER') === false) throw $e;
}
$single = new FieldCatalog(array('data' => array('providers' => array('only-provider'))), array(), array());
provider_assert_same('only-provider', $single->resolveProvider('', 'Projekt 23', 'BKI_PHOTOSET_PROVIDER'), 'Ein einzelner Provider wird nicht automatisch gewählt.');

$configPath = dirname(__DIR__) . '/app/config.php';
$previous = getenv('BKI_PHOTOSET_PROVIDER');
putenv('BKI_PHOTOSET_PROVIDER');
$config = require $configPath;
provider_assert_same('browsercloud', $config['provider_photoset'], 'BKI_PHOTOSET_PROVIDER muss standardmäßig browsercloud verwenden.');
putenv('BKI_PHOTOSET_PROVIDER=browsercloud');
$config = require $configPath;
provider_assert_same('browsercloud', $config['provider_photoset'], 'BKI_PHOTOSET_PROVIDER wird nicht als Präferenz übernommen.');
$previous === false ? putenv('BKI_PHOTOSET_PROVIDER') : putenv('BKI_PHOTOSET_PROVIDER=' . $previous);

$source = file_get_contents(dirname(__DIR__) . '/public/api.php');
$start = strpos($source, "if (\$action === 'start_photoset')");
$end = strpos($source, "if (\$action === 'poll_photoset')", $start);
$block = substr($source, $start, $end - $start);
if (strpos($block, "resolveProvider(") === false || strpos($block, 'BKI_PHOTOSET_PROVIDER') === false) throw new Exception('Projekt 23 löst den Provider nicht gegen die aktuelle Workbench auf.');
if (strpos($block, 'PromptValidation::payload($photosetProvider') === false || strpos($block, '$photosetProvider,') === false) throw new Exception('Der aufgelöste FotoSet-Provider wird nicht unverändert für Resolve und Run genutzt.');

echo "OK: Projekt 23 wählt ausschließlich einen Provider der aktuellen Workbench.\n";
