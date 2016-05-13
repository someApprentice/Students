<?php
namespace App\Model\Entity;

use App\Model\Entity\Student;

class RegisterStudentForm
{
	protected $student;

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
			'password',
			'retryPassword',
		];

		foreach ($allowed as $value) {
			if (isset($data[$value]) and is_scalar($data[$value]) and property_exists($this, $value)) {
				$this->$value = trim($data[$value]);
			}
		}
	}

	function setStudentPassword($authorizer)
	{
		$this->student->setPassword($authorizer, $this->password);
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

    public function getPassword()
    {
        return $this->password;
    }

    public function getRetryPassword()
    {
        return $this->retryPassword;
    }
}
