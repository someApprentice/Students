<?php
namespace App\Model\Entity;

use App\Model\Entity\Student;

class RegisterStudentForm extends Student
{
    protected $password = '';
    protected $retryPassword = '';

    protected $errors = array();

    public function setName()
    {
        if (isset($_POST['name']) and is_scalar($_POST['name'])) {
            $this->name = trim($_POST['name']);
        }
    }

    public function setSurname()
    {
        if (isset($_POST['surname']) and is_scalar($_POST['surname'])) {
            $this->surname = trim($_POST['surname']);
        }
    }

    public function setGender()
    {
        if (isset($_POST['gender']) and is_scalar($_POST['gender'])) {
            $this->gender = trim($_POST['gender']);
        }
    }

    public function setGrupNumber()
    {
        if (isset($_POST['grupnumber']) and is_scalar($_POST['grupnumber'])) {
            $this->grupNumber = trim($_POST['grupnumber']);
        }

    }

    public function setEmail()
    {
        if (isset($_POST['email']) and is_scalar($_POST['email'])) {
            $this->email = trim($_POST['email']);
        }

    }

    public function setsatscores()
    {
        if (isset($_POST['satscores']) and is_scalar($_POST['satscores'])) {
            $this->satScores = trim($_POST['satscores']);
        }

    }

    public function setYearOfBirth()
    {
        if (isset($_POST['yearofbirth']) and is_scalar($_POST['yearofbirth'])) {
            $this->yearOfBirth = trim($_POST['yearofbirth']);
        }
    }

    public function setLocation()
    {
        if (isset($_POST['location']) and is_scalar($_POST['location'])) {
            $this->location = trim($_POST['location']);
        }
    }

    public function setPassword()
    {
        if (isset($_POST['password']) and is_scalar($_POST['password'])) {
            $this->password = trim($_POST['password']);
        }

    }

    public function setRetryPassword()
    {
        if (isset($_POST['retrypassword']) and is_scalar($_POST['retrypassword'])) {
            $this->retryPassword = trim($_POST['retrypassword']);
        }
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRetryPassword()
    {
        return $this->retryPassword;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getError($key)
    {
        if (isset($this->errors[$key])) {
            return $this->errors[$key];
        }
    }
}
