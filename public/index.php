<?php
require_once __DIR__ . '/../app/init.php';

$container['Viewer']->render('templates/head.phtml');

$container['IndexAction']->run();

$container['Viewer']->render('templates/foot.phtml');