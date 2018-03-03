<?php
namespace App\Model\Helper;

class Pager
{
	protected $queries;

	protected $recordsCount;
	protected $recordsPerPage;

	public function __construct($queries, $recordsCount, $recordsPerPage = 10)
	{
		$this->queries = $queries;
		$this->recordsCount = $recordsCount;
		$this->recordsPerPage = $recordsPerPage;
	}

	public function getTotalPages()
	{
		$totalPages = ceil($this->recordsCount / $this->recordsPerPage);

		return $totalPages;
	}

	public function getPreviosPage()
	{
		$previosPage = $this->queries['page'] - 1;

		return $previosPage;
	}

	public function getCurrentPage()
	{
		return $this->queries['page'];
	}

	public function getNextPage()
	{
		$nextPage = $this->queries['page'] + 1;
		
		return $nextPage;
	}

	public function getLinkForPage($n)
	{
		$queries = $this->queries;
		$queries['page'] = $n;

		return http_build_query($queries);
	}

	public function getLimit() {
		$limit = $this->recordsPerPage;

		return $limit;
	}

	public function getOffset() {
		$offset = ($this->queries['page'] - 1) * $this->recordsPerPage;

		return $offset;
	}

	public function getSortLinkBy($sort)
	{
		$queries = $this->queries;
		$queries['sort'] = $sort;

		if ($this->queries['sort'] != $sort) {
			$queries['by'] = 'asc';
		} elseif ($this->queries['by'] == 'asc') {
			$queries['by'] = 'desc';
		} elseif ($this->queries['by'] == 'desc') {
			$queries['by'] = 'asc';
		}

		$link = http_build_query($queries);

		return $link;
	}

	public function getSortPostfix($sort) {
		if ($this->queries['sort'] != $sort) {
			$postfix = '';
		} elseif ($this->queries['by'] == 'asc') {
			$postfix = "&darr;";
		} elseif ($this->queries['by'] == 'desc') {
			$postfix = '&uarr;';
		}

		return $postfix;
	}
}
