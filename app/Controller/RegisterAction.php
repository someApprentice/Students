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

	public function SignUp($name, $surname, $gender, $grupnumber, $email, $satscores, $yearofbirth, $location, $password) {
        $this->errors['name'] = $this->validations->isNameInvalid($name);
        $this->errors['surname'] = $this->validations->isNameInvalid($surname);
        $this->errors['gender'] = $this->validations->isGenderInvalid($gender);
        $this->errors['grupnumber'] = $this->validations->isGrupNumberInvalid($grupnumber);
        $this->errors['email'] = $this->validations->isEmailInvalid($email);
        $this->errors['satscores'] = $this->validations->isSATScoresInvalid($satscores);
        $this->errors['yearofbirth'] = $this->validations->isYearOfBirthInvalid($yearofbirth);
        $this->errors['location'] = $this->validations->isLocationInvalid($location);

        $this->errors['password'] = $this->validations->isPasswordInvalid($password);

	    if (count(array_filter($this->errors))) {
	    	print_r($this->errors);

	        return false;
	    }

	    if ($this->studentgtw->getStudentByEmail($email)) {
	    	$this->errors['email'] = "Email already used.";

	    	return false;
	    }   		

		$salt = $this->reghelper->generateSalt(); //getRegHelper() будет лучше?
		$hash = $this->reghelper->hashPassword($password, $salt);
		$token = $this->reghelper->generateToken();

		$student = new Student($name, $surname, $gender, $grupnumber, $email, $satscores, $yearofbirth, $location, $hash, $salt, $token); //setStudent()? 
		
		$this->studentgtw->addStudent($student);
	}

	public function Register() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $name = isset($_POST['name']) && is_scalar($_POST['name']) ? $_POST['name'] : '';
		    $surname = isset($_POST['surname']) && is_scalar($_POST['surname']) ? $_POST['surname'] : '';
		    $gender = isset($_POST['gender']) && is_scalar($_POST['gender']) ? $_POST['gender'] : '';
		    $grupnumber = isset($_POST['grupnumber']) && is_scalar($_POST['grupnumber']) ? $_POST['grupnumber'] : '';
		    $email = isset($_POST['email']) && is_scalar($_POST['email']) ? $_POST['email'] : '';
		    $satscores = isset($_POST['satscores']) && is_scalar($_POST['satscores']) ? $_POST['satscores'] : '';
		    $yearofbirth = isset($_POST['yearofbirth']) && is_scalar($_POST['yearofbirth']) ? $_POST['yearofbirth'] : '';
			$location = isset($_POST['location']) && is_scalar($_POST['location']) ? $_POST['location'] : '';

		    $password = isset($_POST['password']) && is_scalar($_POST['password']) ? $_POST['password'] : '';
		    $retryPassword = isset($_POST['retrypassword']) && is_scalar($_POST['retrypassword']) ? $_POST['retrypassword'] : '';

		    $name = trim($name);
		    $surname = trim($surname);
		    $grupnumber = trim($grupnumber);
		    $email = trim($email);
		    $satscores = trim($satscores);
		    $yearofbirth = trim($yearofbirth);
		    $password = trim($password);
		    $retryPassword = trim($retryPassword);

		    if ($retryPassword != $password) {
		        $this->errors['retrypassword'] = "Passwords do not match";
		    }

		    $this->SignUp($name, $surname, $gender, $grupnumber, $email, $satscores, $yearofbirth, $location, $password);
		}
	}
}