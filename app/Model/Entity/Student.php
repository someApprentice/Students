<?php
namespace App\Model\Entity;

class Student
{
    protected $id = null;
    protected $name;
    protected $surname;
    protected $gender;
    protected $grupNumber;
    protected $email;
    protected $satScores;
    protected $yearOfBirth;
    protected $location;

    protected $hash;
    protected $salt;
    protected $token;

    public function __construct()
    {

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

    public function seryearOfBirth($yearOfBirth)
    {
        $this->yearOfBirth = $yearOfBirth;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setPassword($password)
    {
        $this->salt = $this->generateSalt();
        $this->hash = $this->hashPassword($password, $this->salt);
        $this->token = $this->generateToken();
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function setToken($token)
    {
        $this->token = $token;
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

    public function getHash()
    {
        return $this->hash;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function generateSalt()
    {
        $salt = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.*-^%$#@!?%&%_=+<>[]{}0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.*-^%$#@!?%&%_=+<>[]{}'), 0, 44);

        return $salt;
    }

    public function hashPassword($password, $salt)
    {
        $hash = md5($password . $salt);

        return $hash;
    }

    public function generateToken()
    {
        $token = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 32);

        return $token;
    }
}
