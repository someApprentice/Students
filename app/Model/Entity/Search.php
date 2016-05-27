<?php
namespace App\Model\Entity;

class Search
{
	protected $query;
	protected $results;

	public function setQuery($query)
	{
		if (is_scalar($query)) {
			$this->query = trim($query);	
		}
	}

	public function setResults($results)
	{
		$this->results = $results;
	}

	public function getQuery()
	{
		return $this->query;
	}

	public function getResults()
	{
		return $this->results;
	}
}