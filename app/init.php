<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Pimple\Container as Pimple;
use App\Model\Helper\RegistrationHelper;
use App\Model\Gateway\StudentGateway;
use App\Controller\RegisterAction;

$container = new Pimple();

$container['PDO'] = function () use ($config) {
	$pdo = new \PDO(
	    $config['db_dsn'],
	    $config['db_user'],
	    $config['db_password']
	);


	$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

	$query = $pdo->prepare("SET sql_mode = 'STRICT_ALL_TABLES'");
	$query->execute();

	return $pdo;

};


$container['RegistrationHelper'] = function () {
	return new RegistrationHelper();
};

$container['StudentGateway'] = function ($c) {
	return new StudentGateway($c['PDO']);
};

$container['RegisterAction'] = function ($c) {
	return new RegisterAction($c['RegistrationHelper'], $c['StudentGateway']);
};