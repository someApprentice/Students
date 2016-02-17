<?php
namespace App\Controller;

use App\Model\Helper\RegistrationHelper;
use App\Model\Validators\Validations;
use App\Model\Gateway\StudentGateway;
use App\Model\Essence\Student;

class RegisterAction {
	protected $reghelper;
	protected $studentgtw;
	protected $validations;

	protected $errors = array();

	public function __construct(RegistrationHelper $reghelper, Validations $validations, StudentGateway $studentgtw) {
		$this->reghelper = $reghelper;
		$this->validations = $validations;
		$this->studentgtw = $studentgtw; 
	}

	public function getErrors() {
		return $this->errors;
	}

	public function SignUp($login, $password) {
		if ($this->studentgtw->getStudentByLogin($login)) {
        	$this->errors['login'] = 'This user already exists';
   		}

        $this->errors['login'] = $this->validations->isLoginInvalid($login);
        $this->errors['password'] = $this->validations->isPasswordInvalid($password);

	    if (count(array_filter($this->errors))) {
	        return false;
	    }   		

		$salt = $this->reghelper->generateSalt(); //getRegHelper() будет лучше?
		$hash = $this->reghelper->hashPassword($password, $salt);
		$token = $this->reghelper->generateToken();

		$student = new Student($login, $hash, $salt, $token); //setStudent()? 
		
		$this->studentgtw->addStudent($student);
	}

	public function Register() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $login = isset($_POST['login']) && is_scalar($_POST['login']) ? $_POST['login'] : '';
		    $password = isset($_POST['password']) && is_scalar($_POST['password']) ? $_POST['password'] : '';
		    $retryPassword = isset($_POST['retrypassword']) && is_scalar($_POST['retrypassword']) ? $_POST['retrypassword'] : '';

		    $login = trim($login);
		    $password = trim($password);
		    $retryPassword = trim($retryPassword);

		    if ($retryPassword != $password) {
		        $this->errors['retrypassword'] = "Passwords do not match";
		    }

		    $this->SignUp($login, $password);
		}
	}

	public function Valid($val) {
		$valid = $this->validations->isLoginInvalid($val);

		return $valid;
	}
}