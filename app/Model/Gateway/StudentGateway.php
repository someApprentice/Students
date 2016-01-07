<?php
namespace App\Model\Gateway;

use App\Model\Essence\Student as Student;

class StudentGateway extends TableDataGateWay {
	protected $pdo;

	public function __construct($pdo) {
		$this->pdo = $pdo;
	}

	protected function getPdo() {
		return $this->pdo;
	}

	public function addStudent() {
		$connect = $this->getPdo();

	    $insert = $connect->prepare("INSERT INTO students (id, student, password, salt, token) VALUES (NULL, :student, :hash, :salt, :token)");
	    $insert->execute(array(
		    ':student' => Student::getStudent(),
		    ':hash' => Student::getHash(),
		    ':salt' => Student::getSalt(),
		    ':token' => Student::getToken()
	    ));

	    return $insert;
	}

	public function removeStudent($id) {
		$connect = $this->getPdo();

	    $insert = $connect->prepare("DELETE FROM students WHERE id=:id");
	    $insert->execute(array(
		    ':id' => $id
	    ));

	    return $insert;		
	}
}