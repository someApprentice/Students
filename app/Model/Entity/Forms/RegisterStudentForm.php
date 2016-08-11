<?php
namespace App\Model\Entity\Forms;

use App\Model\Entity\Student;
use App\Model\Helper\LoginHelper;

class RegisterStudentForm
{
	protected $student;

    protected $token;
    protected $password = '';
    protected $retryPassword = '';

    public function __construct() 
    {
    	$this->student = new Student();
    }

    function fillDataFromArray(array $data)
	{
		$this->student->fillDataFromArray($data);

		$allowed = [
            'token',
			'password',
			'retryPassword',
		];

		foreach ($allowed as $value) {
			if (isset($data[$value]) and is_scalar($data[$value]) and property_exists($this, $value)) {
				$this->$value = trim($data[$value]);
			}
		}

        if ($this->getPassword() != "") {
            $this->setStudentPassword();
        }
	}

    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

	public function setStudentPassword()
	{
		LoginHelper::setPassword($this->student, $this->password);
	}

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRetryPassword($retryPassword)
    {
        $this->retryPassword = $retryPassword;
    }

    public function getStudent()
    {
    	return $this->student;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRetryPassword()
    {
        return $this->retryPassword;
    }
}
