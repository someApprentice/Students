<?php
namespace App\Controller;

use App\Model\Helper\RegistrationHelper as RegistrationHelper;
use \App\Model\Gateway\StudentGateway as StudentGateway;

class RegisterAction {
	static function SignUp($login, $password) {
		$salt = RegistrationHelper::generateSalt();
		$hash = RegistrationHelper::hashPassword($password, $salt);
		$token = RegistrationHelper::generateToken();

		$student = new StudentGateway($login, $hash, $salt, $token);
		$student->addStudent();
	}
}