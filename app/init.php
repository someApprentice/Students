<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Pimple\Container as Pimple;
use App\Model\Helper\RegistrationHelper;
use App\Model\Gateway\StudentGateway;
use App\Controller\RegisterAction;

$container = new Pimple();

$container['PDO'] = $container->factory(function () use ($config) {
	$pdo = new \PDO(
	    $config['db_dsn'],
	    $config['db_user'],
	    $config['db_password']
	);


	$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

	return $pdo;

});

$query = $container['PDO']->prepare("SET sql_mode = 'STRICT_ALL_TABLES'");
$query->execute();


$container['RegistrationHelper'] = $container->factory(function () {
	return new RegistrationHelper();
});

$container['StudentGateway'] = $container->factory(function ($c) {
	return new StudentGateway($c['PDO']);
});

$container['RegisterAction'] = $container->factory(function ($c) {
	return new RegisterAction($c['RegistrationHelper'], $c['StudentGateway']);
});