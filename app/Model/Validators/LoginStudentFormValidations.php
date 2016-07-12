<?php
namespace App\Model\Validators;

use App\Model\Entity\Forms\LoginStudentForm;
use App\Model\Errors\ErrorList;

class LoginStudentFormValidations
{
	public function validLoginStudentForm(LoginStudentForm $loginStudentForm)
	{
		$errors = new ErrorList();

		if ($loginStudentForm->getEmail() === '') {
			$errors->setError('login', 'Email field is empty');
		}

		if ($loginStudentForm->getPassword() === '') {
			$errors->setError('login', 'Password field is empty');
		}

		return $errors;
	}
}