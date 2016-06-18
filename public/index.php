<?php
require_once __DIR__ . '/../app/init.php';

if ($container['LoginAction']->isLoggedIn()) : ?>
	<?php
		$student = $container['StudentGateway']->getStudentByСolumn('id', $_COOKIE['id']);
	?>

<?php if (isset($_GET['notify']) and $_GET['notify'] == "Success") : ?>
	<ins style="color: green;">Edit Success!</ins><br>
<?php endif ?>

Hello, <?= htmlspecialchars($student->getName(), ENT_QUOTES) ?> <?= htmlspecialchars($student->getSurname(), ENT_QUOTES) ?>. Want to <a href="registration.php?token=<?= $_COOKIE['token'] ?>">edit</a> or <a href="logout.php?token=<?= $_COOKIE['token'] ?>&go=/public/index.php">logout?</a>
<?php endif ?>