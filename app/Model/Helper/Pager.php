<?php
namespace App\Model\Helper;

class Pager
{
	protected $queries;
	protected $records;

	protected $recordsCount;
	protected $recordsPerPage;

	public function __construct($queries, $recordsPerPage = 10)
	{
		$this->queries = $queries;
		$this->recordsPerPage = $recordsPerPage;
	}

	public function setRecords(\SplObjectStorage $records)
	{
		$this->records = $records;
	}

	public function setRecordsCount($recordsCount)
	{
		$this->recordsCount = $recordsCount;
	}

	public function getTotalPages()
	{
		$totalPages = ceil($this->recordsCount / $this->recordsPerPage);

		return $totalPages;
	}

	public function getPreviosPage()
	{
		$previosPage = $this->queries['correntPage'] - 1;

		return $previosPage;
	}

	public function getCorrentPage()
	{
		return $this->queries['correntPage'];
	}

	public function getNextPage()
	{
		$nextPage = $this->queries['correntPage'] + 1;
		
		return $nextPage;
	}

	public function getLinkForPage($n)
	{
		if (isset($this->queries['query'])) {
			$queries['query'] = $this->queries['query'];
		}

		$queries['page'] = $n;
		$queries['sort'] = $this->queries['sort'];
		$queries['by'] = $this->queries['by'];

		return http_build_query($queries);
	}

	public function getLimit() {
		$limit = $this->recordsPerPage;

		return $limit;
	}

	public function getOffset() {
		$offset = ($this->queries['correntPage'] - 1) * $this->recordsPerPage;

		return $offset;
	}

	public function getRecords() {
		return $this->records;
	}

	public function getSortLinkBy($sort)
	{
		if (isset($this->queries['query'])) {
			$queries['query'] = $this->queries['query'];
		}

		$queries['page'] = $this->queries['correntPage'];
		$queries['sort'] = $sort;
		$queries['by'] = $this->queries['by']; 

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