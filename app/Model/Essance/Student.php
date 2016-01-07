<?php
namespace App\Model\Essance;

class Student {
	protected $student;
	protected $hash;
	protected $salt;
	protected $token;

	public function __construct() {

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