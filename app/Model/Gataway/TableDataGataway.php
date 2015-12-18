<?php
namespace App\Model\Gataway;

use App\Init as Init;

class TableDataGataway {
	public function addSomething($record) {
		$init = new Init();

		$connect = $init->getPdo();

	    $insert = $connect->prepare("INSERT INTO sometable (somerecord) VALUES (:somerecord)");
	    $insert->execute(array(
	        ':somerecord' => $record
	    ));

	    return $insert;
	}
}