<?php
namespace App\Model\Validators;

use App\Model\Entity\RegisterForm;
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

    public function isNameInvalid($name)
    {
        $error = "";

        if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\-\'\ ]{1,20}$/u', $name, $matches)) {
            $error = "Incorrect name type: name contains invalid characters (valid characters is english or russian letters, hyphens, apostrophes and spaces).";
        } elseif (mb_strlen($name) < 1) {
            $error = "Incorrect name type: name is too short (minimum is 1 charters).";
        } elseif (mb_strlen($name) > 20) {
            $error = "Incorrect name type: name is too long (maximum is 20 charters).";
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
            $error = "Incorrect grup number: valid charcters that number and\or english latters";

            if (mb_strlen($grupnumber) < 2) {
                $error = "Grup number must be more than 2 symbols.";
            } elseif (mb_strlen($grupnumber > 5)) {
                $error = "Grup number must be less than 5 symbols.";
            }
        }

        return $error;
    }

    public function isEmailInvalid($email)
    {
        $error = "";

        if ($student = $this->studentGateway->getStudentByСolumn('email', $email)) {
            $error = "Email already used.";
        }

        if (!preg_match('/.+@.+\..+/i', $email, $matches)) {
            $error = "Incorrect email type: email contains invalid characters (valid characters that english letters, numbers, dushes, and dots).";
        } else if (mb_strlen($email) < 6) {
            $error = "Email is too short.";
        } else if (mb_strlen($email) > 255) {
            $error = "Email must be less than 255 symbols.";
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

    public function isPasswordInvalid($password)
    {
        $error = "";

        if (!preg_match('/^(.){6,20}$/', $password, $matches)) {
            if (mb_strlen($password) < 6) {
                $error = "Incorrect password type: Password is too short (minimum is 6 charters).";

            } elseif (mb_strlen($password) > 20) {
                $error = "Incorrect password type: Password is too long (maximum is 20 charters).";
            }
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

    public function validateRegisterForm(RegisterForm $registerForm)
    {
        $errors['name'] = $this->isNameInvalid($registerForm->getName());
        $errors['surname'] = $this->isNameInvalid($registerForm->getSurname());
        $errors['gender'] = $this->isGenderInvalid($registerForm->getGender());
        $errors['grupnumber'] = $this->isGrupNumberInvalid($registerForm->getGrupnumber());
        $errors['email'] = $this->isEmailInvalid($registerForm->getEmail());
        $errors['satscores'] = $this->isSATScoresInvalid($registerForm->getSatScores());
        $errors['yearofbirth'] = $this->isYearOfBirthInvalid($registerForm->getYearOfBirth());
        $errors['location'] = $this->isLocationInvalid($registerForm->getLocation());

        $errors['password'] = $this->isPasswordInvalid($registerForm->getPassword());
        $errors['retrypassword'] = $this->isPasswordsMatch($registerForm->getPassword(), $registerForm->getRetryPassword());

        return $errors;
    }
}
