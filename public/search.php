<?php
require_once __DIR__ . '/../app/init.php';

$container['Viewer']->render('templates/head.phtml');

$container['SearchAction']->search();

$container['Viewer']->render('templates/foot.phtml');
