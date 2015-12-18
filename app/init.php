<?php
namespace App;

use App\Init as Init;

class Init {
	protected $config = array(
	    'db_dsn' => "mysql:host=localhost; dbname=studentsdb",
	    'db_user' => "root",
	    'db_password' => ""
	);

	protected function getConfig($key) {
	    return $this->config[$key];
	}

	public function getPdo(){
	    static $pdo = null;

	    if (!$pdo) {
	        $pdo = new \PDO(
	            Init::getConfig('db_dsn'),
	            Init::getConfig('db_user'),
	            Init::getConfig('db_password')
	        );

	        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	        $query = $pdo->prepare("SET sql_mode = 'STRICT_ALL_TABLES'");
	        
	        $query->execute();
	    }

	    return $pdo;
	}
}