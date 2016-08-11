<?php
namespace App\Model\Gateway;

use App\Model\Entity\Student;

class StudentGateway extends TableDataGateway
{
    protected $pdo;

    public function getAllStudents($limit = 2147483647, $offset = 0, $order = 'id', $by = 'ASC')
    {
        $pdo = $this->getPdo();

        $query = $pdo->prepare("SELECT * FROM students ORDER BY {$order} {$by} LIMIT :limit OFFSET :offset");
        $query->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $query->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $query->execute();

        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        $students = new \SplObjectStorage();

        foreach ($results as $result) {
            $student = new Student();
            $student->fillAllData($result);

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
        $student->fillAllData($result);

        return $student;
    }

    public function addStudent(Student $student)
    {
        $pdo = $this->getPdo();

        $query = $pdo->prepare("INSERT INTO students (
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
	    		salt
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
	    		:salt
	    	)"
        );

        $query->execute(array(
            ':name' => $student->getName(),
            ':surname' => $student->getSurname(),
            ':gender' => $student->getGender(),
            ':grupnumber' => $student->getGrupNumber(),
            ':email' => $student->getEmail(),
            ':satscores' => $student->getSATScores(),
            ':yearofbirth' => $student->getYearOfBirth(),
            ':location' => $student->getLocation(),
            ':hash' => $student->getHash(),
            ':salt' => $student->getSalt()
        ));
    }

    public function updateStudent(Student $student)
    {
        $pdo = $this->getPdo();

        $query = $pdo->prepare("UPDATE students SET
            name = :name,
            surname = :surname,
            gender = :gender,
            grupnumber = :grupnumber,
            email = :email,
            satscores = :satscores,
            yearofbirth = :yearofbirth,
            location = :location,
            hash = :hash,
            salt = :salt
        WHERE id = :id");
        
        $query->execute(array(
            ':id' => $student->getId(),
            ':name' => $student->getName(),
            ':surname' => $student->getSurname(),
            ':gender' => $student->getGender(),
            ':grupnumber' => $student->getGrupNumber(),
            ':email' => $student->getEmail(),
            ':satscores' => $student->getSATScores(),
            ':yearofbirth' => $student->getYearOfBirth(),
            ':location' => $student->getLocation(),
            ':hash' => $student->getHash(),
            ':salt' => $student->getSalt()
        ));
    }

    public function removeStudent($id)
    {
        $pdo = $this->getPdo();

        $query = $pdo->prepare("DELETE FROM students WHERE id=:id");
        $query->execute(array(
            ':id' => $id,
        ));

        //return $insert;
    }

    public function searchStudents($search, $limit = 2147483647, $offset = 0, $order = 'id', $by = 'ASC')
    {
        $pdo = $this->getPdo();

        $query = $pdo->prepare("SELECT * FROM students WHERE CONCAT(name, surname, grupnumber, email, satscores, yearofbirth, location) LIKE :search ORDER BY {$order} {$by} LIMIT :limit OFFSET :offset");
        $query->bindValue(':search', "%{$search}%");
        $query->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $query->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $query->execute();

        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        $students = new \SplObjectStorage();

        foreach ($results as $result) {
            $student = new Student();
            $student->fillAllData($result);

            $students->attach($student);
        }

        return $students;
    }

    public function getStudentsCount($search = '')
    {
        $pdo = $this->getPdo();

        $query = $pdo->prepare("SELECT COUNT(*) FROM students WHERE CONCAT(name, surname, grupnumber, email, satscores, yearofbirth, location) LIKE :search");
        $query->bindValue(':search', "%{$search}%");
        $query->execute();

        $result = $query->fetchColumn();

        return $result;
    }
}
