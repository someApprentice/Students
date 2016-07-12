<?php
namespace App\Model\Helper;

class Helper
{
    public static function redirect($location = "/public/index.php")
    {
	    if (!preg_match('!^/([^/]|\\Z)!', $location, $matches)) {
	        $location = "/public/index.php";
	    }

	    header("Location: " . $location);
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