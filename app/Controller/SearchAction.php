<?php
namespace App\Controller;

use App\Model\Entity\Search;
use App\Model\Gateway\StudentGateway;
use App\Model\Helper\Pager;

class SearchAction extends Controller
{
	protected $studentGateway;
	protected $viewer;

	public function __construct(StudentGateway $studentGateway) {
		$this->studentGateway = $studentGateway;
	}

	public function search()
	{
		$query = $this->getQuery('query');
		$page = $this->getPageQuery();
		$sort = $this->getSortQuery();
		$by = $this->getByQuery();

		$recordsCount = $this->studentGateway->getStudentsCount($query);

		$pager = new Pager(compact('query', 'page', 'sort', 'by'), $recordsCount);

		$limit = $pager->getLimit();
		$offset = $pager->getOffset();

		$records = $this->studentGateway->searchStudents($query, $sort, $by, $limit, $offset);

		$this->render('templates/search.phtml', compact('query', 'pager', 'records'));
	}
}