<?php
namespace App\Model\Essence;

class Student {
	protected $name;
	protected $surname;
	protected $gender;
	protected $grupnumber;
	protected $email;
	protected $satscores;
	protected $yearofbirth;

	protected $hash;
	protected $salt;
	protected $token;

	public function __construct($name, $surname, $gender, $grupnumber, $email, $satscores, $yearofbirth, $location, $hash, $salt, $token) {
		$this->name = $name;
		$this->surname = $surname;
		$this->gender = $gender;
		$this->grupnumber = $grupnumber;
		$this->email = $email;
		$this->satscores = $satscores;
		$this->yearofbirth = $yearofbirth;
		$this->location = $location;

		$this->hash = $hash;
		$this->salt = $salt;
		$this->token = $token;
	}

	public function setName($student) {
		$this->student = $student;
	}

	public function setSurname($surname) {
		$this->surname = $surname;
	}

	public function setGender($gender) {
		$this->gender = $gender;
	}

	public function setGrupNumber($grupnumber) {
		$this->grupnumber = $grupnumber;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setSATScores($satscores) {
		$this->satscores = $satscores;
	}

	public function serYearOfBirth($yearofbirth) {
		$this->yearofbirth = $yearofbirth;
	}

	public function setLocation($location) {
		$this->location = $location;
	}

	public function setHash($hash) {
		$this->hash = $hash;
	}

	public function setSalt($salt) {
		$this->salt = $salt;
	}

	public function setToken($token) {
		$this->token = $token;
	}

	public function getName() {
		return $this->name;
	}

	public function getSurname() {
		return $this->surname;
	}	

	public function getGender() {
		return $this->gender;
	}

	public function getGrupNumber() {
		return $this->grupnumber;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getSATScores() {
		return $this->satscores;
	}

	public function getYearOfBirth() {
		return $this->yearofbirth;
	}

	public function getLocation() {
		return $this->location;
	}

	public function getHash() {
		return $this->hash;
	}

	public function getSalt() {
		return $this->salt;
	}

	public function getToken() {
		return $this->token;
	}
}