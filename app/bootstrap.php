<?php
// Force UTF-8 consistently, including older PHP 5 / Apache installations.
if (function_exists('ini_set')) {
    @ini_set('default_charset', 'UTF-8');
}
if (function_exists('mb_internal_encoding')) {
    @mb_internal_encoding('UTF-8');
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$config = require __DIR__ . '/config.php';
require_once __DIR__ . '/lib/BkiClient.php';
require_once __DIR__ . '/lib/FieldCatalog.php';
require_once __DIR__ . '/lib/Workflow.php';

function app_config($key, $defaultValue) {
    global $config;
    return isset($config[$key]) ? $config[$key] : $defaultValue;
}

function json_response($payload, $status) {
    if (!headers_sent()) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store, no-cache, must-revalidate');
    }
    echo json_encode($payload);
    exit;
}

function uuid_v4_compat() {
    $data = '';
    if (function_exists('random_bytes')) {
        $data = random_bytes(16);
    } else {
        for ($i = 0; $i < 16; $i++) {
            $data .= chr(mt_rand(0, 255));
        }
    }
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
    $hex = bin2hex($data);
    return substr($hex, 0, 8) . '-' . substr($hex, 8, 4) . '-' . substr($hex, 12, 4) . '-' . substr($hex, 16, 4) . '-' . substr($hex, 20, 12);
}
