<?php
namespace App\Model\Validators;

class Validations {
	public function isLoginInvalid($login) {
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