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
        if (isset($_POST['name'])) {
            $this->name = $_POST['name'];
        }
    }

    public function setSurname()
    {
        if (isset($_POST['surname'])) {
            $this->surname = $_POST['surname'];
        }
    }

    public function setGender()
    {
        if (isset($_POST['gender'])) {
            $this->gender = $_POST['gender'];
        }
    }

    public function setGrupNumber()
    {
        if (isset($_POST['grupnumber'])) {
            $this->grupNumber = $_POST['grupnumber'];
        }

    }

    public function setEmail()
    {
        if (isset($_POST['email'])) {
            $this->email = $_POST['email'];
        }

    }

    public function setsatscores()
    {
        if (isset($_POST['satscores'])) {
            $this->satScores = $_POST['satscores'];
        }

    }

    public function setYearOfBirth()
    {
        if (isset($_POST['yearofbirth'])) {
            $this->yearOfBirth = $_POST['yearofbirth'];
        }
    }

    public function setLocation()
    {
        if (isset($_POST['location'])) {
            $this->location = $_POST['location'];
        }
    }

    public function setPassword()
    {
        if (isset($_POST['password'])) {
            $this->password = $_POST['password'];
        }

    }

    public function setRetryPassword()
    {
        if (isset($_POST['retryPassword'])) {
            $this->retryPassword = $_POST['retrypassword'];
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
