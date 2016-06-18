<?php
namespace App\Model\Validators;

use App\Model\Validators\Validations;
use App\Model\Entity\Student;
use App\Model\Errors\ErrorList;

class StudentValidations extends Validations
{
	protected $validations = [
		'name' => [
			'validator' =>'isNameInvalid',
			'parameters' => ['getName']
		],

		'surname' => [
			'validator' => 'isNameInvalid',
			'parameters' => ['getSurname']
		],

		'gender' => [
			'validator' => 'isGenderInvalid',
			'parameters' => ['getGender']
		],

		'grupnumber' => [
			'validator' => 'isGrupNumberInvalid',
			'parameters' => ['getGrupnumber']
		],

		'email' => [
			'validator' => 'isEmailInvalid',
			'parameters' => ['getEmail', 'getId']
		],

		'satscores' => [
			'validator' => 'isSATScoresInvalid',
			'parameters' => ['getSatScores']
		],

		'yearofbirth' => [
			'validator' => 'isYearOfBirthInvalid',
			'parameters' => ['getYearOfBirth']
		],

		'location' => [
			'validator' => 'isLocationInvalid',
			'parameters' => ['getLocation']
		]
	];

	public function validStudent(Student $student)
	{
		$errors = new ErrorList();

		foreach ($this->validations as $field => $validator) {
			$parameters = array();

			foreach ($validator['parameters'] as $parameter) {
				$parameters[] = call_user_func([$student, $parameter]);
			}

			$errors->setError($field, call_user_func_array([$this, $validator['validator']], $parameters));
		}

		return $errors;
	}
}