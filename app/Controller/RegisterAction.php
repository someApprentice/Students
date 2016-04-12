<?php
namespace App\Controller;

use App\Model\Entity\RegisterForm;
use App\Model\Entity\Student;
use App\Model\Gateway\StudentGateway;
use App\Model\Helper\RegistrationHelper;
use App\Model\Validators\Validations;

class RegisterAction
{
    protected $registrationHelper;
    protected $studentGateway;
    protected $validations;

    public function __construct(RegistrationHelper $registrationHelper, StudentGateway $studentGateway, Validations $validations)
    {
        $this->registrationHelper = $registrationHelper;
        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
    }

    public function register()
    {
        $values = array(
            "id" => '',
            "name" => '',
            "surname" => '',
            "gender" => '',
            "grupnumber" => '',
            "email" => '',
            "satscores" => '',
            "yearofbirth" => '',
            "location" => '',
        );

        $errors = array(
            "id" => '',
            "name" => '',
            "surname" => '',
            "gender" => '',
            "grupnumber" => '',
            "email" => '',
            "satscores" => '',
            "yearofbirth" => '',
            "location" => '',
            "password" => '',
            "retrypassword" => '',
        );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $values = $post = $this->registrationHelper->getPost();

            $registerForm = new RegisterForm();
            $registerForm->setName($post['name']);
            $registerForm->setSurname($post['surname']);
            $registerForm->setGender($post['gender']);
            $registerForm->setGrupNumber($post['grupnumber']);
            $registerForm->setEmail($post['email']);
            $registerForm->setSATScores($post['satscores']);
            $registerForm->setYearOfBirth($post['yearofbirth']);
            $registerForm->setLocation($post['location']);
            $registerForm->setPassword($post['password']);
            $registerForm->setRetryPassword($post['retrypassword']);

            if (!count(array_filter($errors = $this->validations->validateRegisterForm($registerForm)))) {
                $student = new Student();
                $student->setName($post['name']);
                $student->setSurname($post['surname']);
                $student->setGender($post['gender']);
                $student->setGrupNumber($post['grupnumber']);
                $student->setEmail($post['email']);
                $student->setSATScores($post['satscores']);
                $student->serYearOfBirth($post['yearofbirth']);
                $student->setLocation($post['location']);
                $student->setPassword($post['password']);

                $this->studentGateway->addStudent($student);

                $this->registrationHelper->redirect();
            }
        }

        include __DIR__ . '/../../templates/registration.phtml';
    }

}
