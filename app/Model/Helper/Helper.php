<?php
namespace App\Model\Helper;

class Helper
{
    public function redirect($location = "/public/index.php")
    {
	    if (!preg_match('!^/([^/]|\\Z)!', $location, $matches)) {
	        $location = "/public/index.php";
	    }

	    header("Location: " . $location);
	}

	public function validCSRFtoken($token)
	{
		if ($token == $_COOKIE['token']) {
			return true;
		}

		return false;
	}
}