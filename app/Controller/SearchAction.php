<?php
namespace App\Controller;

use App\Model\Entity\Search;
use App\Model\Gateway\StudentGateway;

class SearchAction extneds Controller
{
	protected $studentGateway;

	public function __construct(StudentGateway $studentGateway) {
		$this->studentGateway = $studentGateway;
	}

	public function search()
	{
		$search = new Search();

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$search->setQuery($this->getQuery('query'));

			$results = $this->studentGateway->searchStudents($search->getQuery());

			$search->setResults($results);			
		}

		include __DIR__ . '/../../templates/search.phtml';
	}
}