<?php

$css = file_get_contents(__DIR__ . '/../public/assets/app.css');

if (strpos($css, '.stage{display:none;min-height:620px') === false || strpos($css, 'isolation:isolate') === false) {
    throw new Exception('Die Stage erzeugt keinen eigenen Stapelkontext für die dekorative Ebene.');
}

if (strpos($css, '.stage:before{content:"";position:absolute;z-index:-1;') === false) {
    throw new Exception('Die dekorative Stage-Ebene liegt nicht sicher hinter den Formularen.');
}

if (strpos($css, '.field input,.field select{position:relative;z-index:1;') === false || strpos($css, 'cursor:pointer;pointer-events:auto;touch-action:manipulation') === false) {
    throw new Exception('Inputs und Selects stellen keine vollflächige Klick- und Touch-Fläche bereit.');
}

if (strpos($css, '.form-grid .btn{position:relative;z-index:1;pointer-events:auto;touch-action:manipulation}') === false) {
    throw new Exception('Formularbuttons stellen keine vollflächige Klick- und Touch-Fläche bereit.');
}

if (strpos($css, '.form-grid .btn>*{pointer-events:none}') === false) {
    throw new Exception('Dekorative Button-Inhalte können Klicks weiterhin selbst abfangen.');
}

echo "form_controls_clickability_test: ok\n";
