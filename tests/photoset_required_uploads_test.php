<?php
require_once dirname(__DIR__) . '/app/lib/FieldCatalog.php';
require_once dirname(__DIR__) . '/app/lib/PhotosetUploads.php';

$definitions = array(
    array('id' => 83, 'type' => 'file', 'label' => 'Porträt – Frontalansicht', 'is_required' => true, 'sort_order' => 1),
    array('id' => 84, 'type' => 'file', 'label' => 'Ganzkörper – Frontalansicht', 'is_required' => true, 'sort_order' => 2),
    array('id' => 85, 'type' => 'file', 'label' => 'Porträt – Profilansicht', 'is_required' => true, 'sort_order' => 3),
    array('id' => 86, 'type' => 'file', 'label' => 'Porträt – lächelnd', 'is_required' => true, 'sort_order' => 4),
    array('id' => 87, 'type' => 'file', 'label' => 'Optional', 'is_required' => false, 'sort_order' => 5)
);
$catalog = new FieldCatalog(array('data' => array('resources' => array(array('id' => 30, 'fields' => $definitions)))), array(), array());
$plan = photoset_required_upload_fields($catalog);
$ids = array_map(function($field) { return $field['field_id']; }, $plan);
if ($ids !== array(83, 84, 85, 86)) throw new Exception('Uploadplan ist nicht eindeutig 83, 84, 85, 86: ' . json_encode($ids));

for ($count = 1; $count <= 3; $count++) {
    try {
        assert_photoset_uploads_complete($plan, $count);
        throw new Exception('Start mit ' . $count . ' Bildern wurde akzeptiert.');
    } catch (Exception $e) {
        $expected = $plan[$count]['label'];
        if (strpos($e->getMessage(), $expected) === false) throw new Exception('Konkrete fehlende Feldbezeichnung fehlt: ' . $e->getMessage());
    }
}
assert_photoset_uploads_complete($plan, 4);
echo "OK: 1–3 Bilder werden konkret abgewiesen; Uploadplan ist 83, 84, 85, 86.\n";
