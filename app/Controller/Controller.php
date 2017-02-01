<?php
namespace App\Controller;

class Controller
{
	public function getQuery($query)
	{
		if (isset($_GET[$query]) and is_scalar($_GET[$query])) {
			return $_GET[$query];
		} else {
            return '';
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
            return $_GET['sort'];   
        } else {
            return 'satScores';
        }
    }

    public function getByQuery()
    {
        $byAllowed = [
            'ASC',
            'asc',
            'DESC',
            'desc'
        ];

        if (isset($_GET['by']) and is_scalar($_GET['by']) and in_array($_GET['by'], $byAllowed)) {
            return $_GET['by'];
        } else {
            return 'asc';
        }
    }

	public function getSortQueries()
	{
        $queries['sort'] = $this->getSortQuery();
        $queries['by'] = $this->getByQuery();

		return $queries;
	}

    public static function redirect($location = "/public/index.php")
    {
	    if (!preg_match('!^/([^/]|\\Z)!', $location, $matches)) {
	        $location = "/public/index.php";
	    }

	    header("Location: " . $location);
	}

    public function render($path, array $varibles = array())
    {
        extract($varibles);

        $path = __DIR__ . '/../../' . $path;

        if (file_exists($path)) {
            include $path;
        } else {
            throw new Exception("Invalid template path");
        }
    }
}