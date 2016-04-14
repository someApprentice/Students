<?php
require_once __DIR__ . '/../vendor/autoload.php';

use app\Controller\LoginAction;
use App\Controller\RegisterAction;
use App\Model\Gateway\StudentGateway;
use App\Model\Helper\RegistrationHelper;
use App\Model\Validators\Validations;
use Pimple\Container as Pimple;

$container = new Pimple();

$container['PDO'] = function () {
    $config = parse_ini_file('config.ini');

    $pdo = new \PDO(
        "mysql:host={$config['host']}; dbname={$config['name']}; charset=utf8",
        $config['user'],
        $config['password']
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

$container['Validations'] = function ($c) {
    return new Validations($c['StudentGateway']);
};

$container['RegisterAction'] = function ($c) {
    return new RegisterAction($c['RegistrationHelper'], $c['StudentGateway'], $c['Validations']);
};

$container['LoginAction'] = function ($c) {
    return new LoginAction();
};
