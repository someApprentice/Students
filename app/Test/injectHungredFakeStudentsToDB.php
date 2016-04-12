<?php
require_once __DIR__ . '/../init.php';

use App\Model\Entity\Student;

$faker = Faker\Factory::create('ru_RU');

for ($i = 0; $i < 100; $i++) {
    $student = new Student();
    $student->setName($faker->firstNameMale);
    $student->setSurname($faker->lastName);
    $student->setGender($faker->randomElement(array("Man", "Woman")));
    $student->setGrupNumber($faker->bothify('??##'));
    $student->setEmail($faker->email);
    $student->setSATScores(mt_rand(1, 500));
    $student->serYearOfBirth($faker->year);
    $student->setLocation($faker->randomElement(array("local", "nonresident")));
    $student->setPassword($faker->password);

    $container['StudentGateway']->addStudent($student);
}

echo "ALL OK; Hungred Fake Students injected;";
