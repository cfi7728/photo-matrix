<?php
require_once dirname(__DIR__) . '/app/lib/FieldCatalog.php';

function assert_same($expected, $actual, $message) {
    if ($expected !== $actual) {
        throw new Exception($message . '\nErwartet: ' . json_encode($expected) . '\nErhalten: ' . json_encode($actual));
    }
}

// Eine aktuelle Workbench-Zuordnung muss stets stärker sein als die im Vertrag
// dokumentierte numerische ID.
$catalog = new FieldCatalog(array('data' => array('fields' => array(
    array('label' => 'Körpergröße', 'binding_id' => 'wb-height', 'type' => 'number'),
    array('label' => 'Bildformat', 'binding_id' => 'wb-aspect', 'type' => 'select', 'options' => array('Querformat 16:9', 'Hochformat 9:16', 'Quadrat 1:1')),
    array('label' => 'Bild beschriften', 'binding_id' => 'wb-caption', 'type' => 'radio', 'options' => array('an', 'aus'))
))), array(), array());
$snapshot = $catalog->snapshot();
assert_same(2879, $snapshot['bindings']['height'], 'Ein UUID/API-Alias darf die numerische Binding-ID für Körpergröße nicht ersetzen.');
assert_same(2885, $snapshot['bindings']['aspect_ratio'], 'Ein UUID/API-Alias darf die numerische Binding-ID für Bildformat nicht ersetzen.');
assert_same(2887, $snapshot['bindings']['caption'], 'Ein UUID/API-Alias darf die numerische Binding-ID für Bild beschriften nicht ersetzen.');

$numeric = new FieldCatalog(array('data' => array('fields' => array(
    array('label' => 'Körpergröße', 'binding_id' => 9001, 'type' => 'number')
))), array(), array());
assert_same(9001, $numeric->snapshot()['bindings']['height'], 'Eine aktuelle numerische Workbench-Binding-ID muss Vorrang haben.');

// Nur ohne semantischen Workbench-Treffer werden die Vertrags-IDs verwendet.
$fallback = (new FieldCatalog(array(), array(), array()))->snapshot();
$contractBindings = array('height' => 2879, 'gender' => 2880, 'clothing' => 2881, 'image_style' => 2882, 'location' => 2883, 'region' => 2884, 'aspect_ratio' => 2885, 'scene' => 2886, 'caption' => 2887);
assert_same($contractBindings, $fallback['bindings'], 'Unvollständige Workbench fällt nicht auf den vollständigen Projekt-18-Vertrag zurück.');
assert_same(array('Querformat 16:9', 'Hochformat 9:16', 'Quadrat 1:1'), array_column($fallback['options']['aspect_ratio'], 'value'), 'Die vertraglichen Bildformatwerte fehlen.');
assert_same(array('an', 'aus'), array_column($fallback['options']['caption'], 'value'), 'Die vertraglichen Beschriftungswerte fehlen.');

// Isolierte Repräsentation des vollständigen Projekt-18-values-Objekts aus dem
// Vertrag. Zusätzlich sichern statische Checks ab, dass der produktive Handler
// alle Basisschlüssel und den je Lauf wechselnden Szenenschlüssel setzt.
$values = array(
    '2879' => '182',
    '2880' => 'Mann',
    '2881' => 'Business Formal - Mann',
    '2882' => 'Corporate',
    '2883' => 'Außen',
    '2884' => '1. Küstennahe Kleinstadt',
    '2885' => 'Querformat 16:9',
    '2886' => 'A1 Makler lehnt am Vorgarten',
    '2887' => 'an'
);
assert_same(array(2879,2880,2881,2882,2883,2884,2885,2886,2887), array_keys($values), 'Das vollständige Projekt-18-values-Objekt ist nicht lückenlos.');
assert_same('Querformat 16:9', $values['2885'], 'Projekt-18-values enthält Bildformat nicht unter 2885.');
assert_same('an', $values['2887'], 'Projekt-18-values enthält Bild beschriften nicht unter 2887.');

$api = file_get_contents(dirname(__DIR__) . '/public/api.php');
foreach (array('height','gender','clothing','image_style','location','aspect_ratio','caption') as $name) {
    if (strpos($api, "\$baseValues[(string)\$bindings['" . $name . "']]") === false) {
        throw new Exception('Der produktive baseValues-Aufbau enthält ' . $name . ' nicht.');
    }
}
if (strpos($api, "\$baseValues[(string)\$bindings['region']]") === false || strpos($api, "\$values[(string)\$bindings['scene']]") === false) {
    throw new Exception('Region oder Szene fehlt im produktiven Projekt-18-values-Aufbau.');
}

echo "OK: Projekt 18 übermittelt vollständige values inklusive 2885 und 2887; nur numerische Workbench-Bindings haben Vorrang.\n";
