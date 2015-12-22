<?php
namespace App\Model\Gateway;

class TableDataGateway {
	public function addUser($login, $hash, $salt, $token) {
		$connect = getPdo();

	    $insert = $connect->prepare("INSERT INTO users (id, login, password, salt, token) VALUES (NULL, :login, :hash, :salt, :token)");
	    $insert->execute(array(
		    ':login' => $login,
		    ':hash' => $hash,
		    ':salt' => $salt,
		    ':token' => $token
	    ));

	    return $insert;
	}
}