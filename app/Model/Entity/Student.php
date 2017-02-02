<?php
namespace App\Model\Entity;

use App\Model\Helper\LoginHelper as Authorizer;

class Student
{
    protected $id = null;
    protected $name = '';
    protected $surname = '';
    protected $gender = '';
    protected $grupNumber = '';
    protected $email = '';
    protected $satScores = '';
    protected $yearOfBirth = '';
    protected $location = '';

    protected $hash;
    protected $salt;

    public function fillDataFromArray(array $data)
	{
		$allowed = [
			'name', 
			'surname',
			'gender',
			'grupNumber',
			'email',
			'satScores',
			'yearOfBirth',
			'location'
		];

		foreach ($allowed as $value) {
			if (isset($data[$value]) and is_scalar($data[$value]) and property_exists($this, $value)) {
				$this->$value = trim($data[$value]);
			}
		}
	}

    public function fillAllData(array $data)
	{
		foreach ($data as $property => $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
		}
	}

	public function setProperty($property, $value) {
		$this->$property = $value;
	}

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setGrupNumber($grupNumber)
    {
        $this->grupNumber = $grupNumber;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setSATScores($satScores)
    {
        $this->satScores = $satScores;
    }

    public function serYearOfBirth($yearOfBirth)
    {
        $this->yearOfBirth = $yearOfBirth;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setPassword($password)
    {
        Authorizer::setPassword($this, $password);
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getProperty($property) {
    	return $this->$property;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getGrupNumber()
    {
        return $this->grupNumber;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSATScores()
    {
        return $this->satScores;
    }

    public function getYearOfBirth()
    {
        return $this->yearOfBirth;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getSalt()
    {
        return $this->salt;
    }
}
