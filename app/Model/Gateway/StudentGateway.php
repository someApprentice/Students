<?php
namespace App\Model\Gateway;

use App\Model\Entity\Student;

class StudentGateway extends TableDataGateWay
{
    protected $pdo;

    public function getAllStudents()
    {
        $pdo = $this->getPdo();

        $query = $pdo->prepare("SELECT * FROM students");
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        $students = new \SplObjectStorage();

        foreach ($result as $value) {
            $student = new Student();
            $student->setId($value['id']);
            $student->setName($value['name']);
            $student->setSurname($value['surname']);
            $student->setGender($value['gender']);
            $student->setGrupNumber($value['grupnumber']);
            $student->setEmail($value['email']);
            $student->setSATScores($value['satscores']);
            $student->serYearOfBirth($value['yearofbirth']);
            $student->setLocation($value['location']);
            $student->setHash($value['password']);
            $student->setSalt($value['salt']);
            $student->setToken($value['token']);

            $students->attach($student);
        }

        return $students;
    }

    public function getStudentByСolumn($column, $value)
    {
        $pdo = $this->getPdo();

        $query = $pdo->prepare("SELECT * FROM students WHERE {$column}=:value");
        $query->bindValue(':value', $value);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return false;
        }

        $student = new Student();
        $student->setId($result['id']);
        $student->setName($result['name']);
        $student->setSurname($result['surname']);
        $student->setGender($result['gender']);
        $student->setGrupNumber($result['grupnumber']);
        $student->setEmail($result['email']);
        $student->setSATScores($result['satscores']);
        $student->serYearOfBirth($result['yearofbirth']);
        $student->setLocation($result['location']);
        $student->setHash($result['password']);
        $student->setSalt($result['salt']);
        $student->setToken($result['token']);

        return $student;
    }

    public function addStudent(Student $student)
    {
        $pdo = $this->getPdo();

        $insert = $pdo->prepare("INSERT INTO students (
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
            ':token' => $student->getToken(),
        ));
    }

    public function removeStudent($id)
    {
        $pdo = $this->getPdo();

        $insert = $pdo->prepare("DELETE FROM students WHERE id=:id");
        $insert->execute(array(
            ':id' => $id,
        ));

        //return $insert;
    }
}
