<?php
namespace App\Model\Validators;

use App\Model\Gateway\StudentGateway;

class Validations
{
    const GENDER_MALE = "Man";
    const GENDER_FEMALE = "Woman";

    const LOCATION_LOCAL = "local";
    const LOCATION_NONRESIDENT = "nonresident";

    protected $studentGateway;

    public function __construct(StudentGateway $studentGateway)
    {
        $this->studentGateway = $studentGateway;
    }

    public function validLenght($string, $minLenght, $maxLenght)
    {
        $error = "";

        if (mb_strlen($string) < $minLenght) {
            $error = "It is too small min characters is $minLenght";
        } else if (mb_strlen($string) > $maxLenght) {
            $error = "It is too big max characters is $maxLenght";
        }

        return $error;
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


    public function validateLoginStudentForm(LoginStudentForm $loginStudentForm)
    {
        $errors['login'] = ('' === $loginStudentForm->getLogin()) ? "Login field is empty" : "";
        $errors['password'] = ('' === $loginStudentForm->getPassword()) ? "Password field is empty" : "";

        return $errors;
    }
}
