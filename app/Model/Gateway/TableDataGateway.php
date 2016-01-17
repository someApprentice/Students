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

	public function addUser(User $user) {
		$connect = $this->getPdo();

	    $insert = $connect->prepare("INSERT INTO users (id, login, password, salt, token) VALUES (NULL, :login, :hash, :salt, :token)");
	    $insert->execute(array(
		    ':login' => $user->login,
		    ':hash' => $user->hash,
		    ':salt' => $user->salt,
		    ':token' => $user->token
	    ));

	    return $insert;
	}
}