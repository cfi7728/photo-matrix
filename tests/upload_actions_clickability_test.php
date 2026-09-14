<?php
// Regressionstest: Die sichtbaren Upload-Aktionen bleiben echte, delegiert behandelte Buttons.
$js = file_get_contents(dirname(__DIR__) . '/public/assets/app.js');
$css = file_get_contents(dirname(__DIR__) . '/public/assets/app.css');

if (strpos($js, "uploadGrid.addEventListener('click',handleUploadAction)") === false) {
    throw new Exception('Dem Upload-Grid fehlt der delegierte Click-Handler.');
}
if (strpos($js, "button.closest('.image-card')") === false || strpos($js, "button.classList.contains('replace')") === false || strpos($js, "button.classList.contains('remove')") === false) {
    throw new Exception('Tauschen und Entfernen werden nicht anhand des geklickten Buttons ausgelöst.');
}
if (strpos($js, 'aria-label="Referenzfoto tauschen"') === false || strpos($js, 'aria-label="Referenzfoto entfernen"') === false) {
    throw new Exception('Die Upload-Aktionen sind nicht zugänglich beschriftet.');
}
if (strpos($css, '.upload-grid .image-card>img,.upload-grid .image-card>.slot{pointer-events:none}') === false) {
    throw new Exception('Dekorative Kartenebenen können die Aktionsbuttons abfangen.');
}

echo "OK: Tauschen und Entfernen sind als anklickbare Upload-Aktionen verdrahtet.\n";
