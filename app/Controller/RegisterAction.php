<?php
namespace App\Controller;

use App\Model\Helper\RegistrationHelper as RegistrationHelper;
use App\Model\Gateway\StudentGateway as StudentGateway;
use App\Model\Essence\Student as Student;

class RegisterAction {
	static function SignUp($login, $password) {
		$salt = RegistrationHelper::generateSalt();
		$hash = RegistrationHelper::hashPassword($password, $salt);
		$token = RegistrationHelper::generateToken();

		Student::setStudent($login);
		Student::setHash($hash);
		Student::setSalt($salt);
		Student::setToken($token);

		$student = new StudentGateway();
		$student->addStudent();
	}
}