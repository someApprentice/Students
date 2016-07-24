<?php
namespace App\Model\Helper;

class Pager
{
	protected $records;
	protected $correntPage;
	protected $queries;
	protected $recordsPerPage;

	public function __construct($records, $correntPage, array $queries = array(), $recordsPerPage = 10)
	{
		$this->records = $records;
		$this->correntPage = $correntPage;
		$this->queries = $queries;
		$this->recordsPerPage = $recordsPerPage;

		$this->sort();
	}

	public function getTotalPages()
	{
		$recordsCount = $this->records->count();

		$totalPages = ceil($recordsCount / $this->recordsPerPage);

		return $totalPages;
	}

	public function getPreviosPage()
	{
		$previosPage = $this->correntPage - 1;

		return $previosPage;
	}

	public function getCorrentPage()
	{
		return $this->correntPage;
	}

	public function getNextPage()
	{
		$nextPage = $this->correntPage + 1;
		
		return $nextPage;
	}

	public function getLinkForPage($n)
	{
		$this->queries['page'] = $n;

		return http_build_query($this->queries);
	}

	public function getRecordsOnCorrentPage()
	{
		$recordsOnCorrentPage = new \SplObjectStorage();
		
		$from = ($this->correntPage - 1) * $this->recordsPerPage;
		$to = $this->correntPage * $this->recordsPerPage - 1;

		foreach ($this->records as $student) {
			if ($this->records->key() >= $from and $this->records->key() <= $to) {
				$recordsOnCorrentPage->attach($student);
			} 	
		}

		return $recordsOnCorrentPage;
	}

	public function sort()
	{
		$sort = $this->queries['sort'];

		foreach ($this->records as $student) {
			$array[] = $student;
		}

		if ($this->queries['by'] == 'asc') {
			usort($array, function($a, $b) use ($sort) {
			    if ($a->getProperty($sort) == $b->getProperty($sort)) {
			        return 0;
			    }

			    return ($a->getProperty($sort) > $b->getProperty($sort)) ? -1 : 1;
			});
		} elseif ($this->queries['by'] == 'desc') {
			usort($array, function($a, $b) use ($sort) {
			    if ($a->getProperty($sort) == $b->getProperty($sort)) {
			        return 0;
			    }

			    return ($a->getProperty($sort) < $b->getProperty($sort)) ? -1 : 1;
			});
		}

		$sortedRecords = new \SplObjectStorage();

		foreach ($array as $student) {
			$sortedRecords->attach($student);
		}

		$this->records = $sortedRecords;
	}

	public function getSortLink($sort)
	{
		$queries = $this->queries;

		$queries['sort'] = $sort;
		$queries['page'] = $this->correntPage;
		
		if ($this->queries['sort'] != $sort) {
			$queries['by'] = 'asc';
			$postfix = '';
		} elseif ($this->queries['by'] == 'asc') {
			$queries['by'] = 'desc';
			$postfix = "&darr;";
		} elseif ($this->queries['by'] == 'desc') {
			$queries['by'] = 'asc';
			$postfix = '&uarr;';
		}

		$link = http_build_query($queries);

		$linkNamePostfix = $postfix;

		return compact('link', 'linkNamePostfix');
	}
}