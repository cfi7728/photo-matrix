<?php

function photoset_required_upload_fields($catalog) {
    if (!($catalog instanceof FieldCatalog)) throw new Exception('Projekt 23: Ressourcen-Katalog fehlt.');
    $fields = $catalog->requiredResourceFields();
    if (!count($fields)) throw new Exception('Projekt 23: Die Workbench liefert keine als Pflichtfeld markierten Ressourcenfelder.');
    return $fields;
}

function photoset_missing_upload_labels($requiredFields, $uploadCount) {
    $missing = array();
    foreach (array_values($requiredFields) as $index => $field) {
        if ($index < max(0, intval($uploadCount))) continue;
        $label = isset($field['label']) ? trim((string)$field['label']) : '';
        $missing[] = $label !== '' ? $label : 'Aufnahme für Feld #' . $field['field_id'];
    }
    return $missing;
}

function assert_photoset_uploads_complete($requiredFields, $uploadCount) {
    $missing = photoset_missing_upload_labels($requiredFields, $uploadCount);
    if (count($missing)) throw new Exception(implode(', ', $missing) . ' fehlt' . (count($missing) > 1 ? 'en' : '') . '.');
    if (intval($uploadCount) > count($requiredFields)) throw new Exception('Projekt 23 erwartet genau ' . count($requiredFields) . ' Pflichtaufnahmen.');
}
