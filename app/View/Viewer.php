<?php
namespace App\View;

class Viewer {
	public function render($path, array $varibles = array())
	{
		extract($varibles);

		$path = __DIR__ . '/../../' . $path;

		if (file_exists($path)) {
			include $path;
		} else {
			throw new Exception("Invalid template path");
		}
	}
}