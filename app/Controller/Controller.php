<?php
namespace App\Controller;

class Controller
{
	public function getQuery($query)
	{
		if (isset($_GET[$query]) and is_scalar($_GET[$query])) {
			return $_GET[$query];
		}
	}

	public function getPageQuery()
	{
		if (isset($_GET['page']) and is_numeric($_GET['page'])) {
			return $_GET['page'];
		} else {
			return 1;
		}
	}

	public function getSortQuery()
	{
        $orderAllowed = [
            'id',
            'name',
            'surname',
            'grupNumber',
            'email',
            'satScores',
            'yearOfBirth',
            'location'
        ];

		if (isset($_GET['sort']) and is_scalar($_GET['sort']) and in_array($_GET['sort'], $orderAllowed)) {
            $queries['sort'] = $_GET['sort'];   
		} else {
			$queries['sort'] = 'satScores';
		}


        $byAllowed = [
            'ASC',
            'asc',
            'DESC',
            'desc'
        ];

        if (isset($_GET['by']) and is_scalar($_GET['by']) and in_array($_GET['by'], $byAllowed)) {
            $queries['by'] = $_GET['by'];
        } else {
			$queries['by'] = 'asc';
		}

		return $queries;
	}

    public static function redirect($location = "/public/index.php")
    {
	    if (!preg_match('!^/([^/]|\\Z)!', $location, $matches)) {
	        $location = "/public/index.php";
	    }

	    header("Location: " . $location);
	}
}