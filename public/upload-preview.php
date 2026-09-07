<?php
require_once dirname(__DIR__) . '/app/bootstrap.php';
$flow = new Workflow();
$index = isset($_GET['index']) ? intval($_GET['index']) : -1;
$uploads = $flow->get('uploads', array());
if (!isset($uploads[$index]) || !is_file($uploads[$index]['path'])) { http_response_code(404); exit; }
header('Content-Type: ' . $uploads[$index]['mime']);
header('Cache-Control: private, max-age=60');
readfile($uploads[$index]['path']);
