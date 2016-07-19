<?php
namespace App\Model\Helper;

class Helper
{
	public function getCookie($cookie)
	{
		if (isset($_COOKIE[$cookie]) and $_COOKIE[$cookie] != '') {
			return $_COOKIE[$cookie];
		} else {
			throw new \Exception("Invalid cookie");
		}
	}

    public static function generateToken()
    {
        $token = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 32);

        return $token;
    }

	public function createToken() {
		if (isset($_COOKIE['token'])) {
			$token = $_COOKIE['token'];
		} else {
			$token = $this->generateToken();
		}

        $expires = 60 * 60 * 24 * 30 * 12 * 3;
        setcookie('token', $token, time() + $expires, '/', null, null, true);

        return $token;
	}

	public function validToken($token)
	{
		if (isset($_COOKIE['token'])) {
			if ($token != "" and $_COOKIE['token'] != "" and $token === $_COOKIE['token']) {
				return true;
			}
		}

		return false;
	}
}