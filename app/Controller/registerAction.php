<?php
namespace App\Controller;

use App\Model\Halper\RegistrationHelper as RegistrationHelper;

class RegisterAction {
	static function SignUp($login, $password) {
		$salt = RegistrationHelper::generateSalt();
		$hash = RegistrationHelper::hashPassword($password, $salt);
		$token = RegistrationHelper::generateToken();

		$student = new App\Model\Gateway\StudentGateway($login, $hash, $salt, $token);
		$student->addStudent();
	}
}