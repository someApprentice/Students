<?php
namespace App\Controller;

class Controller
{
	public function getQuery($query)
	{
		if (isset($_GET[$query]) and is_scalar($_GET[$query])) {
			return $_GET[$query];
		} else {
			throw new \Exception("Invalid query");
		}
	}

    public static function redirect($location = "/public/index.php")
    {
	    if (!preg_match('!^/([^/]|\\Z)!', $location, $matches)) {
	        $location = "/public/index.php";
	    }

	    header("Location: " . $location);
	}
}