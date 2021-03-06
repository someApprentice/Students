<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Gateway\StudentGateway;
use App\Model\Validators\Validations;
use App\Model\Validators\StudentValidations;
use App\Model\Validators\RegisterStudentFormValidations;
use App\Model\Validators\LoginStudentFormValidations;
use App\Model\Helper\Helper;
use App\Model\Helper\LoginHelper;
use App\Model\Helper\LoginHelper as Authorizer;
use App\Controller\IndexAction;
use App\Controller\RegisterAction;
use App\Controller\LoginAction;
use App\Controller\SearchAction;
use App\View\Viewer;

use Pimple\Container as Pimple;

$container = new Pimple();

$container['PDO'] = function () {
    $config = parse_ini_file(__DIR__ . '/config.ini');

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

$container['Authorizer'] = function () {
    return new Authorizer();
};

$container['StudentGateway'] = function ($c) {
    return new StudentGateway($c['PDO']);
};

$container['Validations'] = function ($c) {
    return new Validations($c['StudentGateway']);
};

$container['StudentValidations'] = function ($c) {
    return new StudentValidations($c['StudentGateway']);
};

$container['RegisterStudentFormValidations'] = function ($c) {
    return new RegisterStudentFormValidations($c['StudentGateway'], $c['StudentValidations']);
};

$container['LoginStudentFormValidations'] = function ($c) {
    return new LoginStudentFormValidations();
};

$container['Helper'] = function ($c) {
    return new Helper();
};

$container['LoginHelper'] = function ($c) {
    return new LoginHelper($c['StudentGateway']);
};

$container['IndexAction'] = function ($c) {
    return new IndexAction($c['StudentGateway'], $c['Helper'], $c['LoginHelper']);
};

$container['LoginAction'] = function ($c) {
    return new LoginAction($c['StudentGateway'], $c['LoginStudentFormValidations'], $c['Helper'], $c['LoginHelper']);
};

$container['RegisterAction'] = function ($c) {
    return new RegisterAction($c['StudentGateway'], $c['RegisterStudentFormValidations'], $c['LoginAction'], $c['Helper'], $c['LoginHelper']);
};

$container['SearchAction'] = function ($c) {
    return new SearchAction($c['StudentGateway']);
};