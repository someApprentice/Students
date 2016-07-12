<?php
namespace App\Model\Helper;

use App\Model\Gateway\StudentGateway;
use App\Model\Entity\Student;

class LoginHelper extends Helper
{
    protected $studentGateway;

    public function __construct(StudentGateway $studentGateway) {
        $this->studentGateway = $studentGateway;
    }

    public function isLoggedIn()
    {
        if (isset($_COOKIE['id'])) {
            $student = $this->studentGateway->getStudentByСolumn('id', $_COOKIE['id']);

            if (isset($_COOKIE['token'])) {
                if ($student->getHash() == $_COOKIE['hash']) {
                    return $student;
                }
            }
        }

        return false;
    }

    public function createCookies(Student $student)
    {
        $expires = 60 * 60 * 24 * 30 * 12 * 3;

        setcookie('id', $student->getId(), time() + $expires, '/', null, null, true);
        setcookie('hash', $student->getHash(), time() + $expires, '/', null, null, true);
        setcookie('token', $this->generateToken(), time() + $expires, '/', null, null, true);
    }

    public function deleteCookies()
    {
        setcookie('id', null, time()-1, '/');
        setcookie('hash', null, time()-1, '/');
        setcookie('token', null, time()-1, '/');
    }

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
}