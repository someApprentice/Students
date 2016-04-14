<?php
namespace App\Model\Entity;

class LoginStudentForm
{
    protected $login = '';
    protected $password = '';

    protected $errors = array();

    public function setLogin()
    {
        if (isset($_POST['login']) and is_scalar($_POST['login'])) {
            $this->login = trim($_POST['login']);
        }
    }

    public function setPassword()
    {
        if (isset($_POST['password']) and is_scalar($_POST['password'])) {
            $this->password = trim($_POST['password']);
        }

    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function setError($key, $value)
    {
        $this->errors[$key] = $value;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
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
