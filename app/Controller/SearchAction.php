<?php
namespace App\Controller;

use App\Model\Entity\Search;
use App\Model\Gateway\StudentGateway;
use App\Model\Helper\Pager;
use App\View\Viewer;

class SearchAction extends Controller
{
	protected $studentGateway;
	protected $viewer;

	public function __construct(StudentGateway $studentGateway, Viewer $viewer) {
		$this->studentGateway = $studentGateway;
		$this->viewer = $viewer;
	}

	public function search()
	{
		if ($_GET) {
			$query = $this->getQuery('query');

			$this->viewer->render('templates\search.phtml', compact('query'));

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

			$this->viewer->render('templates\list.phtml', compact('pager'));
		} else {
			$this->viewer->render('templates\search.phtml', compact('query'));
		}
	}
}