<?php
namespace App\Model\Gateway;

use App\Model\Essence\Student as Student;

class StudentGateway extends TableDataGateWay {
	protected $pdo;
	protected $student;

	public function __construct(\PDO $pdo, Student $student) {
		$this->pdo = $pdo;
		$this->student = $student;
	}

	protected function getPdo() {
		return $this->pdo;
	}

	public function addStudent() {
		$connect = $this->getPdo();

	    $insert = $connect->prepare("INSERT INTO students (id, student, password, salt, token) VALUES (NULL, :student, :hash, :salt, :token)");
	    $insert->execute(array(
		    ':student' => $this->student->getStudent(),
		    ':hash' => $this->student->getHash(),
		    ':salt' => $this->student->getSalt(),
		    ':token' => $this->student->getToken()
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