<?php
namespace App\Model\Errors;

class ErrorList 
{
	protected $errors = array();

	public function setError($field, $error)
	{
		$this->errors[$field] = $error;
	}

	public function getError($field)
	{
		if (array_key_exists($field, $this->errors)) {
			return $this->errors[$field];	
		}
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function hasErrors()
	{
		if (count(array_filter($this->errors))) {
			return true;
		}
	}

	public function unsetError($field)
	{
		if (array_key_exists($field, $this->errors)) {
			unset($this->errors[$field]);	
		}
	}	
}