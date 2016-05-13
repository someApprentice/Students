<?php
namespace App\Model\Helper;

class Helper
{
    public function redirect($location)
    {
	    if (preg_match('!^/([^/]|\\Z)!', $location, $matches)) {
	        header("Location: " . $location);
	    }
	}
}