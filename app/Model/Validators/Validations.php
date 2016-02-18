<?php
namespace App\Model\Validators;

class Validations {
	public function isNameInvalid($login) {
	    $error = "";

	    if(!preg_match('/^[\\w\\(\\)\\.\\*-]{3,20}$/', $login, $matches)) {
	        if(!preg_match('/^[\\w\\(\\)\\.\\*-]*$/', $login, $matches)) {
	            $error = "Incorrect login type: Login contains invalid characters (valid characters that english letters, numbers, underscores, parentheses, periods, asterisks and dashes.).";
	        } elseif(mb_strlen($login) < 3) {
	            $error = "Incorrect login type: Login is too short (minimum is 3 charters).";
	        } elseif(mb_strlen($login) > 20) {
	            $error = "Incorrect login type: Login is too long (maximum is 20 charters).";
	        }
	    }

	    return $error;
	}

	public function isGenderInvalid($gender) {
		$error = "";

		if ($gender != "Man" and $gender = "Woman") {
			$error = "Choos your gender.";

		}

		return $error;
	}

	public function isGrupNumberInvalid($grupnumber) {
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

	public function isEmailInvalid($email) {
		$error = "";

		if (!preg_match('/^([.\\w-]{2,127})@([a-zA-Z0-9-.]{2,122}).([a-zA-Z]{2,5})$/', $email, $matches)) {
			$error = "Incorrect login type: Login contains invalid characters (valid characters that english letters, numbers, dushes, and dots).";
		} else if (mb_strlen($email) < 6) {
			$error = "Email is too short.";
		} else if (mb_strlen($email) > 255) {
			$error = "Email must be less than 255 symbols.";
		}

		return $error;
	}

	public function isSATScoresInvalid($satscores) {
		$error = "";

		if ($satscores > 475) {
			$error = "SAT scores is too big.";
		} elseif ($satscores < 60) {
			$error = "SAT scores is to small.";
		}

		return $error;
	}

	public function isYearOfBirthInvalid($yearofbirth) {
		$error = "";

		if (!preg_match('/^\\d{2}$|^\\d{4}$/', $yearofbirth, $matches)) {
			$error = "Year of birth must be in two-digit four-digit format: 01, 1901";
		} 

		return $error;
	}

	public function isLocationInvalid($location) {
		$error = "";

		if ($location != "local" and $location != "nonresident") {
			$error = "Choos your location";
		}

		return $error;
	}

	public function isPasswordInvalid($password) {
	    $error = "";

	    //if(!preg_match('/^[\\w\\(\\)\\.\\*\\-!@#\\$%\\^&><\\+=]{3,20}$/', $password, $matches)) {
	    if(!preg_match('/^.{6,20}$/', $password, $matches)) {
	        if(mb_strlen($password) < 6) {
	            $error = "Incorrect password type: Password is too short (minimum is 6 charters).";
	        } elseif(mb_strlen($password) > 100) {
	            $error = "Incorrect password type: Password is too long (maximum is 100 charters).";
	        }
	    }

	    return $error;
	}
}