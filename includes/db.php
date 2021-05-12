<?php

define('WEBSITE_NAME', 'Coding City Lite');
define('WEBSITE_URL', 'http://localhost:8000');

$host = 'mysql:dbname=php_l1';
$user = 'root';
$password = 'root';

try {
    $db = new PDO($host, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}