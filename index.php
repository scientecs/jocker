<?php

session_start();

header('Content-Type: text/html; charset=utf-8', true);

error_reporting(E_ERROR);
ini_set('display_errors', 1);

define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '1');
define('DB_DATABASE', 'jocker');
define('DB_PREFIX', 'oc_');

require_once __DIR__ . '/bootstrap/app.php';
