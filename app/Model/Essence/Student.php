<?php
namespace App\Model\Essence;

class Student {
	protected $student;
	protected $hash;
	protected $salt;
	protected $token;

	public function __construct($student, $hash, $salt, $token) {
		$this->student = $student;
		$this->hash = $hash;
		$this->salt = $salt;
		$this->token = $token;
	}

	public function setStudent($student) {
		$this->student = $student;
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

	public function getStudent() {
		return $this->student;
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