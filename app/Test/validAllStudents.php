<?php
require_once __DIR__ . '/../init.php';

$students = $container['StudentGateway']->getAllStudents();

$errors = array();

foreach ($students as $student) {
    $studentErrors = $container['StudentValidations']->validStudent($student);

    if ($studentErrors->hasErrors()) {
        $errors[] = array(
            'id' => $student->getId(),
            'errors' => $studentErrors,
        );
    }
}

echo "<pre>";
var_dump($errors);
echo "</pre>";