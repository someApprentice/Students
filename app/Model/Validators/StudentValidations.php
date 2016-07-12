<?php
namespace App\Model\Validators;

use App\Model\Validators\Validations;
use App\Model\Entity\Student;
use App\Model\Errors\ErrorList;

class StudentValidations extends Validations
{
    const GENDER_MALE = "Man";
    const GENDER_FEMALE = "Woman";

    const LOCATION_LOCAL = "local";
    const LOCATION_NONRESIDENT = "nonresident";
	
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

	    public function isNameInvalid($name)
    {
        $error = "";

        if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\-\'\ ]{1,20}$/u', $name, $matches)) {
            if (null == $error = validLenght($name, 1, 20)) {
                $error = "Incorrect name type: name contains invalid characters (valid characters is english or russian letters, hyphens, apostrophes and spaces).";
            }
        }

        return $error;
    }

    public function isGenderInvalid($gender)
    {
        $error = "";

        if ($gender != self::GENDER_MALE and $gender != self::GENDER_FEMALE) {
            $error = "Choos your gender.";

        }

        return $error;
    }

    public function isGrupNumberInvalid($grupnumber)
    {
        $error = "";

        if (!preg_match('/^[0-9a-zA-Z]{2,5}$/', $grupnumber, $matches)) {
            if (null == $error = $this->validLenght($grupnumber, 2, 5)) {
                $error = "Incorrect grup number: valid charcters that number and\or english latters";
            }
        }

        return $error;
    }

    public function isEmailInvalid($email, $skipStudentWithId = null)
    {
        $error = "";

        if ($student = $this->studentGateway->getStudentByСolumn('email', $email)) {
            if ($student->getId() != $skipStudentWithId) {
                $error = "Email already used.";
            }  
        }

        if (!preg_match('/.+@.+\..+/i', $email, $matches)) {
            if (null == $error = $this->validLenght($email, 6, 255)) {
                $error = "Incorrect email type: email contains invalid characters (valid characters that english letters, numbers, dushes, and dots).";
            }
        }

        return $error;
    }

    public function isSATScoresInvalid($satscores)
    {
        $error = "";

        if ($satscores > 475) {
            $error = "SAT scores is too big.";
        } elseif ($satscores < 60) {
            $error = "SAT scores is to small.";
        }

        return $error;
    }

    public function isYearOfBirthInvalid($yearofbirth)
    {
        $error = "";

        if (!preg_match('/^\\d{4}$/', $yearofbirth, $matches)) {
            $error = "Year of birth must be in four-digit format: 1901";
        } elseif ($yearofbirth < 1901) {
            $error = "Year of birth must be more then 1901";
        } elseif ($yearofbirth > 2155) {
            $error = "Year of birth must be lesse then 2155";
        }

        return $error;
    }

    public function isLocationInvalid($location)
    {
        $error = "";

        if ($location != self::LOCATION_LOCAL and $location != self::LOCATION_NONRESIDENT) {
            $error = "Choos your location";
        }

        return $error;
    }
}