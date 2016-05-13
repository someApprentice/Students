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

        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        $students = new \SplObjectStorage();

        foreach ($results as $result) {
            $student = new Student();
            $student->fillDataFromDB($result);

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
        $student->fillDataFromDB($result);

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
	    		hash,
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
