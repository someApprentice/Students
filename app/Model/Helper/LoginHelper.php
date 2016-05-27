<?php
namespace App\Model\Helper;

use App\Model\Entity\Student;

class LoginHelper extends Helper
{
	public function isPasswordValid(Student $student, $password) {
		if ($student->getHash() == $this->hashPassword($password, $student->getSalt())) {
			return true;
		}

		return false;
	}

    public static function generateSalt()
    {
        $salt = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.*-^%$#@!?%&%_=+<>[]{}0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.*-^%$#@!?%&%_=+<>[]{}'), 0, 44);

        return $salt;
    }

    public static function hashPassword($password, $salt)
    {
        $hash = md5($password . $salt);

        return $hash;
    }

    public static function generateToken()
    {
        $token = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 32);

        return $token;
    }
}