<?php
class Login {
	protected $login = '';
	protected $password = '';

	protected $remebmer = '';

	protected $errors = array(
		'login' => '',
		'password' => ''
		);


	//Получают данные из $_POST и возвращают ошибки если есть. 
	getLogin() {}
	getPassword() {}

	//Если ошибок нет, то получает из БД пользователя (сравнивает хеш с солью) и создает $_СЕССИЮ и $_ПЕЧЕНИЕ, или в противном случае,
	//возвращает false.
	signIn() {}

	//Проверяет есть ли $_СЕССИЯ или $_ПЕЧЕНИЕ 
	isItSignIn() {}
}