<?php
require_once __DIR__ . '/../app/init.php';


$container['Viewer']->render('templates/head.phtml');

$container['RegisterAction']->register();

$container['Viewer']->render('templates/foot.phtml');

