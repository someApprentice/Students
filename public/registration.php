<?php
require_once __DIR__ . '/../app/init.php';

$container['RegisterAction']->register();

require __DIR__ . '/../templates/registration.phtml';