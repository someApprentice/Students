<?php
namespace App\Model\Cookies;

use App\Model\Entity\Entity;

interface Cookies
{
	public function createCookies(Entity $entity);

	public function deleteCookies();
}