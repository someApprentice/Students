<?php
namespace App\Model\Cookies;

use App\Model\Entity\Entity;

class StudentCookies implements Cookies
{
	protected $allowed = [
			'id',
			'name', 
			'surname',
			'gender',
			'grupNumber',
			'email',
			'satScores',
			'yearOfBirth',
			'location',
			'token'
		];

	public function createCookies(Entity $student)
	{
		$expires = $expires = 60 * 60 * 24 * 30 * 12 * 3;

		foreach ($this->allowed as $value) {
			if (property_exists($student, $value)) {
				setcookie($value, call_user_func([$student, 'getProperty'], $value), time() + $expires, '/', 'localhost', null, true);
			}
		}
	}

	public function deleteCookies()
	{
		foreach ($this->allowed as $value) {
		    unset($_COOKIE[$value]);

		    setcookie($value, null, time()-1, '/');
		}
	}
}