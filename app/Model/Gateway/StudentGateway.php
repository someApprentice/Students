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
	
	public function getStudentByName($name) {
		$connect = $this->getPdo();

	    $user = $connect->prepare("SELECT * FROM students WHERE name=:name");
	    $user->bindValue(':name', $name, \PDO::PARAM_STR);
	    $user->execute();

	    $result = $user->fetch(\PDO::FETCH_ASSOC);

    	return $result;		
	}

	public function getStudentBySurname($surname) {
		$connect = $this->getPdo();

	    $user = $connect->prepare("SELECT * FROM students WHERE surname=:surname");
	    $user->bindValue(':surname', $surname, \PDO::PARAM_STR);
	    $user->execute();

	    $result = $user->fetch(\PDO::FETCH_ASSOC);

    	return $result;		
	}

	public function getStudentByEmail($email) {
		$connect = $this->getPdo();

	    $user = $connect->prepare("SELECT * FROM students WHERE email=:email");
	    $user->bindValue(':email', $email, \PDO::PARAM_STR);
	    $user->execute();

	    $result = $user->fetch(\PDO::FETCH_ASSOC);

    	return $result;		
	}

	public function addStudent(Student $student) {
		$connect = $this->getPdo();

	    $insert = $connect->prepare("INSERT INTO students (
	    		id,
	    		name,
	    		surname,
	    		gender,
	    		grupnumber,
	    		email,
	    		satscores,
	    		yearofbirth,
	    		location,
	    		password,
	    		salt,
	    		token
 	    	) VALUES (
	    		NULL,
	    		:name,
	    		:surname,
	    		:gender,
	    		:grupnumber,
	    		:email,
	    		:satscores,
	    		:yearofbirth,
	    		:location,
	    		:hash,
	    		:salt,
	    		:token
	    	)"
	    );

	    $insert->execute(array(
		    ':name' => $student->getName(),
		    ':surname' => $student->getSurname(),
		    ':gender' => $student->getGender(),
		    ':grupnumber' => $student->getGrupNumber(),
		    ':email' => $student->getEmail(),
		    ':satscores' => $student->getSATScores(),
		    ':yearofbirth' => $student->getYearOfBirth(),
		    ':location' => $student->getLocation(),
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