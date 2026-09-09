<?php
return array(
    'api_base' => getenv('BKI_API_BASE') ? getenv('BKI_API_BASE') : 'http://bki.immonia.intern/api/v1',
    'api_key' => getenv('BKI_API_KEY') ? getenv('BKI_API_KEY') : '',
    'project_photoset' => 23,
    'project_scene' => 18,
    // Optionaler harter Override, falls die BKI-Workbench mehrere Ressourcenfelder
    // liefert oder eine Installation die Felddefinition anders strukturiert.
    // Leer lassen = automatisch und strikt aus der Workbench ermitteln.
    // Mehrere Ressourcenbilder werden laut BKI jeweils auf ein eigenes Feld hochgeladen.
    // Optional können die Feld-IDs kommasepariert vorgegeben werden.
    'photoset_resource_field_ids' => getenv('BKI_PHOTOSET_FIELD_IDS') ? getenv('BKI_PHOTOSET_FIELD_IDS') : '',
    'scene_resource_field_ids' => getenv('BKI_SCENE_FIELD_IDS') ? getenv('BKI_SCENE_FIELD_IDS') : '',
    // Legacy-Override für Installationen mit genau einem Ressourcenfeld.
    'photoset_resource_field_id' => getenv('BKI_PHOTOSET_FIELD_ID') ? getenv('BKI_PHOTOSET_FIELD_ID') : '',
    'scene_resource_field_id' => getenv('BKI_SCENE_FIELD_ID') ? getenv('BKI_SCENE_FIELD_ID') : '',
    'provider_photoset' => 'browsercloud',
    'provider_scene' => 'vehabi',
    // Optionale Binding-Overrides für Projekt 18. Normalerweise werden diese
    // automatisch aus der Workbench gelesen. Nur setzen, falls die Installation
    // ein abweichendes Workbench-Schema verwendet.
    'binding_height' => getenv('BKI_BINDING_HEIGHT') ? getenv('BKI_BINDING_HEIGHT') : '',
    'binding_gender' => getenv('BKI_BINDING_GENDER') ? getenv('BKI_BINDING_GENDER') : '',
    'binding_clothing' => getenv('BKI_BINDING_CLOTHING') ? getenv('BKI_BINDING_CLOTHING') : '',
    'binding_image_style' => getenv('BKI_BINDING_IMAGE_STYLE') ? getenv('BKI_BINDING_IMAGE_STYLE') : '',
    'binding_location' => getenv('BKI_BINDING_LOCATION') ? getenv('BKI_BINDING_LOCATION') : '',
    'binding_region' => getenv('BKI_BINDING_REGION') ? getenv('BKI_BINDING_REGION') : '',
    'binding_scene' => getenv('BKI_BINDING_SCENE') ? getenv('BKI_BINDING_SCENE') : '',
    'storage' => dirname(__DIR__) . '/storage',
    'max_uploads' => 4,
    'max_file_bytes' => 12 * 1024 * 1024,
    'allowed_mime' => array('image/jpeg', 'image/png', 'image/webp'),
    'verify_tls' => false
);
