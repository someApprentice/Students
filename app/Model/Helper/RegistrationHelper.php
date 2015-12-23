<?php
namespace App\Model\Helper;

class RegistrationHelper {
	static function generateSalt() {	
	    $salt = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.*-^%$#@!?%&%_=+<>[]{}0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.*-^%$#@!?%&%_=+<>[]{}'), 0, 44);

	    return $salt;
	}

	static function hashPassword($password, $salt) {
	    $hash = md5($password . $salt);

	    return $hash;
	}

	static function generateToken() {
	    $token = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 32);

	    return $token;
	}
}