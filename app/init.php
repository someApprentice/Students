<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

print_r($config['db_dsn']);
    
$pdo = null;

$pdo = new \PDO(
    $config['db_dsn'],
    $config['db_user'],
    $config['db_password']
);

$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$query = $pdo->prepare("SET sql_mode = 'STRICT_ALL_TABLES'");

$query->execute();

