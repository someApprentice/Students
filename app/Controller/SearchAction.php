<?php
namespace App\Controller;

use App\Model\Entity\Search;
use App\Model\Gateway\StudentGateway;

class SearchAction
{
	protected $studentGateway;

	public function __construct(StudentGateway $studentGateway) {
		$this->studentGateway = $studentGateway;
	}

	public function search()
	{
		$search = new Search();

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (isset($_GET['query']) and $_GET['query'] != '') {
				$search->setQuery($_GET['query']);

				$results = $this->studentGateway->searchStudents($search->getQuery());

				$search->setResults($results);
			}

		}

		include __DIR__ . '/../../templates/search.phtml';
	}
}