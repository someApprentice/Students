<?php
namespace App\Model\Entity;

class RegisterForm
{
    protected $name = '';
    protected $surname = '';
    protected $gender = '';
    protected $grupNumber = '';
    protected $email = '';
    protected $satScores = '';
    protected $yearOfBirth = '';
    protected $location = '';

    protected $password = '';
    protected $retryPassword = '';

    public function __construct()
    {

    }

    public function setName($student)
    {
        $this->name = $student;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setgrupNumber($grupNumber)
    {
        $this->grupNumber = $grupNumber;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setsatScores($satScores)
    {
        $this->satScores = $satScores;
    }

    public function setyearOfBirth($yearOfBirth)
    {
        $this->yearOfBirth = $yearOfBirth;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setretryPassword($retryPassword)
    {
        $this->retryPassword = $retryPassword;
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

    public function getgrupNumber()
    {
        return $this->grupNumber;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getsatScores()
    {
        return $this->satScores;
    }

    public function getyearOfBirth()
    {
        return $this->yearOfBirth;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getretryPassword()
    {
        return $this->retryPassword;
    }

    public function getForm()
    {

    }
}
