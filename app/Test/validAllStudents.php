<?php
require_once __DIR__ . '/../init.php';

$students = $container['StudentGateway']->getAllStudents();

$errors = array();

foreach ($students as $student) {
    $error['name'] = $container['Validations']->isNameInvalid($student->getName());
    $error['surname'] = $container['Validations']->isNameInvalid($student->getSurname());
    $error['gender'] = $container['Validations']->isGenderInvalid($student->getGender());
    $error['grupnumber'] = $container['Validations']->isGrupNumberInvalid($student->getGrupnumber());
    $error['satscores'] = $container['Validations']->isSATScoresInvalid($student->getSatScores());
    $error['yearofbirth'] = $container['Validations']->isYearOfBirthInvalid($student->getYearOfBirth());
    $error['location'] = $container['Validations']->isLocationInvalid($student->getLocation());

    if (count(array_filter($error))) {
        $errors[] = array(
            'id' => $student->getId(),
            'errors' => $error,
        );
    }
}

var_dump($errors);
