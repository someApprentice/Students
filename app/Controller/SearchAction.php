<?php
namespace App\Controller;

use App\Model\Entity\Search;
use App\Model\Gateway\StudentGateway;

class SearchAction extends Controller
{
	protected $studentGateway;

	public function __construct(StudentGateway $studentGateway) {
		$this->studentGateway = $studentGateway;
	}

	public function search()
	{
		if ($_GET) {
			$query = $this->getQuery('query');

			$results = $this->studentGateway->searchStudents($query);		
		}

		include __DIR__ . '/../../templates/search.phtml';
	}
}