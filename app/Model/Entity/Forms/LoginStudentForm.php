<?php
namespace App\Model\Entity\Forms;

class LoginStudentForm
{
    protected $email = '';
    protected $password = '';

    function fillDataFromArray(array $data)
    {
        $allowed = [
            'email',
            'password',
        ];

        foreach ($allowed as $value) {
            if (isset($data[$value]) and is_scalar($data[$value]) and property_exists($this, $value)) {
                $this->$value = trim($data[$value]);
            }
        }
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
