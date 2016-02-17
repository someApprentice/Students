<?php
namespace App\Model\Gateway;

use App\Model\Essence\Student;

class StudentGateway extends TableDataGateWay {
	protected $pdo;

	public function getStudentById($id) {
		$connect = $this->getPdo();

	    $user = $connect->prepare("SELECT * FROM students WHERE id=:id");
	    $user->bindValue(':id', $id, \PDO::PARAM_STR);
	    $user->execute();

	    $result = $user->fetch(\PDO::FETCH_ASSOC);

    	return $result;		
	}
	
	public function getStudentByLogin($login) {
		$connect = $this->getPdo();

	    $user = $connect->prepare("SELECT * FROM students WHERE student=:login");
	    $user->bindValue(':login', $login, \PDO::PARAM_STR);
	    $user->execute();

	    $result = $user->fetch(\PDO::FETCH_ASSOC);

    	return $result;		
	}

	public function addStudent(Student $student) {
		$connect = $this->getPdo();

	    $insert = $connect->prepare("INSERT INTO students (id, student, password, salt, token) VALUES (NULL, :student, :hash, :salt, :token)");
	    $insert->execute(array(
		    ':student' => $student->getStudent(),
		    ':hash' => $student->getHash(),
		    ':salt' => $student->getSalt(),
		    ':token' => $student->getToken()
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