<?php
require_once __DIR__ . '/../app/init.php';

if ($container['LoginAction']->isLoggedIn()) : ?>
Hello, <?= htmlspecialchars($_COOKIE['name'], ENT_QUOTES) ?> <?= htmlspecialchars($_COOKIE['surname'], ENT_QUOTES) ?>. Want to <a href="logout.php?token=<?= $_COOKIE['token'] ?>&go=/public/index.php">logout?</a>
<?php endif ?>