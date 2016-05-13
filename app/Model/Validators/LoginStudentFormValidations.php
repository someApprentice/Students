<?php
namespace App\Model\Validators;

use App\Model\Entity\LoginStudentForm;
use App\Model\Errors\ErrorList;

class LoginStudentFormValidations
{
	public function validLoginStudentForm(LoginStudentForm $loginStudentForm)
	{
		$errors = new ErrorList();

		if ($loginStudentForm->getLogin() === '') {
			$errors->setError('login', 'Login field is empty');
		}

		if ($loginStudentForm->getPassword() === '') {
			$errors->setError('login', 'Password field is empty');
		}

		return $errors;
	}
}