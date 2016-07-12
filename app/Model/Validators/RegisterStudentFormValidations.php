<?php
namespace App\Model\Validators;

use App\Model\Validators\Validations;
use App\Model\Gateway\StudentGateway;
use App\Model\Validators\StudentValidations;
use App\Model\Entity\Forms\RegisterStudentForm;
use App\Model\Errors\ErrorList;

class RegisterStudentFormValidations extends Validations
{
	protected $validations = [
        'password' => [
        	'validator' => 'isPasswordInvalid',
        	'parameters' => ['getPassword']
        ],

        'retrypassword' => [
        	'validator' => 'isPasswordsMatch', 
        	'parameters' => ['getPassword', 'getRetryPassword']
        ]
	];

    protected $studentGateway;

    public function __construct(StudentGateway $studentGateway, StudentValidations $studentValidations)
    {
        $this->studentGateway = $studentGateway;
        $this->studentValidations = $studentValidations;
    }

	public function validRegisterStudentForm(RegisterStudentForm $registerStudentForm, $editMode = false)
	{

		$errors = $this->studentValidations->validStudent($registerStudentForm->getStudent());

		foreach ($this->validations as $field => $validator) {
			$parameters = array();

			foreach ($validator['parameters'] as $parameter) {
				$parameters[] = call_user_func([$registerStudentForm, $parameter]);
			}

			//Если включен режим редактирования, то к валидации пароля добавляем параметр сообщающий об этом.
			if ($field = 'password' and $editMode) {
				$parameters[] = true;
			}

			$errors->setError($field, call_user_func_array([$this, $validator['validator']], $parameters));
		}

		return $errors;

	}

    public function isPasswordInvalid($password, $editMode = false)
    {
        $error = "";

        if ($editMode and $password = "") {
            return $error;
        }

        if (!preg_match('/^(.){6,20}$/', $password, $matches)) {
            $error = $this->validLenght($password, 6, 20);
        }

        return $error;
    }

    public function isPasswordsMatch($password, $retrypassword)
    {
        $error = "";

        if ($password != $retrypassword) {
            $error = "Passwords do not match";
        }

        return $error;
    }
}