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
		if ($_GET) {
			$query = $this->getQuery('query');

			$this->render('templates\search.phtml', compact('query'));

			$correntPage = $this->getPageQuery();

			$sortQueries = $this->getSortQuery();
	        $sort = $sortQueries['sort'];
	        $by = $sortQueries['by'];

			$pager = new Pager(compact('query', 'correntPage', 'sort', 'by'));

			$limit = $pager->getLimit();
			$offset = $pager->getOffset();

			$records = $this->studentGateway->searchStudents($query, $sort, $by, $limit, $offset);

			$recordsCount = $this->studentGateway->getStudentsCount($query);

			$pager->setRecords($records);
			$pager->setRecordsCount($recordsCount);

			$this->render('templates\list.phtml', compact('pager'));
		} else {
			$this->render('templates\search.phtml');
		}
	}
}