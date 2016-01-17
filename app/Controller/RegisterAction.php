<?php
namespace App\Controller;

use App\Model\Helper\RegistrationHelper as RegistrationHelper;
use App\Model\Gateway\StudentGateway as StudentGateway;
use App\Model\Essence\Student as Student;

class RegisterAction {
	static function SignUp($login, $password, \PDO $pdo) {
		$salt = RegistrationHelper::generateSalt();
		$hash = RegistrationHelper::hashPassword($password, $salt);
		$token = RegistrationHelper::generateToken();

		$student = new Student($login, $hash, $salt, $token);

		$studentgtw = new StudentGateway($pdo);
		
		$studentgtw->addStudent($student);
	}
}