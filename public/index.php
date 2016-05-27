<?php
require_once __DIR__ . '/../app/init.php';

if ($container['LoginAction']->isLoggedIn()) : ?>
	<?php
		$student = $container['StudentGateway']->getStudentByСolumn('id', $_COOKIE['id']);
	?>

Hello, <?= htmlspecialchars($student->getName(), ENT_QUOTES) ?> <?= htmlspecialchars($student->getSurname(), ENT_QUOTES) ?>. Want to <a href="edit.php?token=<?= $_COOKIE['token'] ?>">edit</a> or <a href="logout.php?token=<?= $_COOKIE['token'] ?>&go=/public/index.php">logout?</a>
<?php endif ?>