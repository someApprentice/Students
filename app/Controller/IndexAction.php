<?php
namespace App\Controller;

use App\Model\Gateway\StudentGateway;
use App\Model\Helper\Helper;
use App\Model\Helper\LoginHelper;
use App\Model\Helper\Pager;
use App\View\Viewer;

class IndexAction extends Controller
{
	protected $studentGateway;
	protected $helper;
	protected $loginHelper;
	protected $viewer;

	public function __construct(StudentGateway $studentGateway, Helper $helper, LoginHelper $loginHelper, Viewer $viewer)
	{
		$this->studentGateway = $studentGateway;
		$this->helper = $helper;
		$this->loginHelper = $loginHelper;
		$this->viewer = $viewer;
	}

	public function run()
	{
		$this->viewer->render('templates/head.phtml');

		$loggedStudent = $this->loginHelper->isLoggedIn();

		$notify = $this->getQuery('Success');

		$token = $this->helper->getCookie('token');

		$this->viewer->render('templates/index.phtml', compact('loggedStudent', 'notify', 'token'));


		$correntPage = $this->getPageQuery();

		$sortQueries = $this->getSortQuery();
        $sort = $sortQueries['sort'];
        $by = $sortQueries['by'];
        
		$pager = new Pager(compact('correntPage', 'sort', 'by'));

		$limit = $pager->getLimit();
		$offset = $pager->getOffset();

		$records = $this->studentGateway->getStudents($sort, $by, $limit, $offset);

		$recordsCount = $this->studentGateway->getStudentsCount();

		$pager->setRecords($records);
		$pager->setRecordsCount($recordsCount);

		$this->viewer->render('templates/list.phtml', compact('pager'));


		$this->viewer->render('templates/foot.phtml');
	}
}