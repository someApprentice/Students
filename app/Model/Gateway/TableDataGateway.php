<?php
namespace App\Model\Gateway;

class TableDataGateway {
	protected $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getPdo() {
		return $this->pdo;
	}
}