<?php
namespace App\Model\Gateway;

class StudentGateway extends TableDataGateWay {
	protected $student;
	protected $hash;
	protected $salt;
	protected $token;

	protected $errors = array();

	protected $pdo;

	public function __construct($student, $hash, $salt, $token) {
		$this->student = $student;
		$this->hash = $hash;
		$this->salt = $salt;
		$this->token = $token;
	}

	public function getStudent() {
		return $this->student;
	}

	public function getHash() {
		return $this->hash;
	}

	public function getSalt() {
		return $this->salt;
	}

	public function getToken() {
		return $this->token;
	}

	public function getPdo() {
		require __DIR__ . '/../../config.php';
		require __DIR__ . '/../../init.php';

		return $pdo;
	}

	public function addStudent() {
		$connect = $this->getPdo();

	    $insert = $connect->prepare("INSERT INTO students (id, student, password, salt, token) VALUES (NULL, :student, :hash, :salt, :token)");
	    $insert->execute(array(
		    ':student' => $this->getStudent(),
		    ':hash' => $this->getHash(),
		    ':salt' => $this->getSalt(),
		    ':token' => $this->getToken()
	    ));

	    return $insert;
	}

	public function removeStudent($id) {
		$connect = getPdo();

	    $insert = $connect->prepare("DELETE FROM students WHERE id=:id");
	    $insert->execute(array(
		    ':id' => $id
	    ));

	    return $insert;		
	}
}