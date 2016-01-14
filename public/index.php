<?php
require_once __DIR__ . '/../app/init.php';

use App\Controller\RegisterAction as RegisterAction;

RegisterAction::SignUp('somelogin', 'somepassword', $pdo);