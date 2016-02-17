<?php
namespace App\Controller;

use App\Model\Helper\RegistrationHelper;
use App\Model\Gateway\StudentGateway;
use App\Model\Essence\Student;

class RegisterAction {
	protected $reghelper;
	protected $studentgtw;

	public function __construct(RegistrationHelper $reghelper, StudentGateway $studentgtw) {
		$this->reghelper = $reghelper;
		$this->studentgtw = $studentgtw; 
	}

	public function SignUp($login, $password) {
		$salt = $this->reghelper->generateSalt(); //getRegHelper() будет лучше?
		$hash = $this->reghelper->hashPassword($password, $salt);
		$token = $this->reghelper->generateToken();

		$student = new Student($login, $hash, $salt, $token); //setStudent()? 
		
		$this->studentgtw->addStudent($student);
	}
}