<?php
namespace App\Controller;

use App\Model\Entity\RegisterStudentForm;
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
        $registerStudentForm = new RegisterStudentForm();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $registerStudentForm->setName();
            $registerStudentForm->setSurname();
            $registerStudentForm->setGender();
            $registerStudentForm->setGrupNumber();
            $registerStudentForm->setEmail();
            $registerStudentForm->setSATScores();
            $registerStudentForm->setYearOfBirth();
            $registerStudentForm->setLocation();
            $registerStudentForm->setPassword();
            $registerStudentForm->setRetryPassword();

            $registerStudentForm->setErrors($this->validations->validateRegisterStudentForm($registerStudentForm));

            if (!count(array_filter($registerStudentForm->getErrors()))) {
                $student = new Student();
                $student->setName($registerStudentForm->getName());
                $student->setSurname($registerStudentForm->getSurname());
                $student->setGender($registerStudentForm->getGender());
                $student->setGrupNumber($registerStudentForm->getGrupNumber());
                $student->setEmail($registerStudentForm->getEmail());
                $student->setSATScores($registerStudentForm->getSATScores());
                $student->setYearOfBirth($registerStudentForm->getYearOfBirth());
                $student->setLocation($registerStudentForm->getLocation());
                $student->setPassword($registerStudentForm->getPassword());

                $this->studentGateway->addStudent($student);

                $this->registrationHelper->redirect();
            }
        }

        include __DIR__ . '/../../templates/registration.phtml';
    }

}
