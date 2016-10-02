<?php
namespace App\Controller;

use App\Model\Gateway\StudentGateway;
use App\Model\Helper\Helper;
use App\Model\Helper\LoginHelper;
use App\Model\Helper\Pager;

class IndexAction extends Controller
{
	protected $studentGateway;
	protected $helper;
	protected $loginHelper;

	public function __construct(StudentGateway $studentGateway, Helper $helper, LoginHelper $loginHelper)
	{
		$this->studentGateway = $studentGateway;
		$this->helper = $helper;
		$this->loginHelper = $loginHelper;
	}

	public function run()
	{
		$loggedStudent = $this->loginHelper->isLoggedIn();

		$notify = $this->getQuery('Success');

		$token = $this->helper->getCookie('token');

		$this->render('templates/index.phtml', compact('loggedStudent', 'notify', 'token'));


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

		$this->render('templates/list.phtml', compact('pager'));
	}
}