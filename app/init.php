<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

function getConfig($key) {
    global $config;

    return $config[$key];
}
	
function getPdo(){
    $pdo = null;

    if (!$pdo) {
        $pdo = new \PDO(
            getConfig('db_dsn'),
            getConfig('db_user'),
            getConfig('db_password')
        );

        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $query = $pdo->prepare("SET sql_mode = 'STRICT_ALL_TABLES'");
        
        $query->execute();
    }

    return $pdo;
}
