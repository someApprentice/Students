<?php
//Проверяет на ошибки и выполняет функции необходимые при ригистрации. 
Class Registration {
	protected $login = '';
	protected $password = '';
	protected $retryPassword = '';

	protected $errors = array(
		'login' => '',
		'password' => '',
		'retryPassword' => ''
		);

	//Получаем значение форм из $_POST
	//Как правильно назвать эти функции в этом случае? Set?
	getLogin() {} 
	getPassword() {}
	getRetryPassword() {}

	//Проверяем на ошибки, и если их нет, то солим\хешируем пароль, генерируем токен и добавляем пользователя в БД,
	//создаем $_СЕССИИ и $_ПЕЧЕНИЕ
	//Перенаправляем, например, на главную
	//иначе - возвращаем false
	signUp() {}