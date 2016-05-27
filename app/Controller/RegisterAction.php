<?php
namespace App\Controller;

use App\Model\Gateway\StudentGateway;
use App\Model\Entity\RegisterStudentForm;
use App\Model\Validators\RegisterStudentFormValidations;
use App\Model\Errors\ErrorList;
use App\Model\Entity\Student;
use App\Model\Helper\Helper;
use App\Controller\LoginAction;

class RegisterAction
{
    protected $studentGateway;
    protected $validations;
    protected $loginAction;

    public function __construct(StudentGateway $studentGateway, RegisterStudentFormValidations $validations, LoginAction $loginAction)
    {
        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
        $this->loginAction = $loginAction;
    }

    public function register()
    {
        $registerStudentForm = new RegisterStudentForm();

        $errors = new ErrorList;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $registerStudentForm->fillDataFromArray($_POST);

            $errors = $this->validations->validRegisterStudentForm($registerStudentForm);

            if (!$errors->hasErrors()) {
                $registerStudentForm->setStudentPassword();

                $this->studentGateway->addStudent($registerStudentForm->getStudent());

                $this->loginAction->login();

                Helper::redirect($_GET['go']);
            }
        }

        include __DIR__ . '/../../templates/registration.phtml';
    }

    public function edit()
    {
        if (isset($_GET['token']) and $this->loginAction->isLoggedIn()) {
            if ($_GET['token'] == $_COOKIE['token']) {
                $student = $this->studentGateway->getStudentByСolumn('id', $_COOKIE['id']);

                $registerStudentForm = new RegisterStudentForm();
                $registerStudentForm->setStudent($student);

                $errors = new ErrorList;

                $success = false;

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $registerStudentForm->fillDataFromArray($_POST);

                    $errors = $this->validations->validRegisterStudentForm($registerStudentForm);

                    if (!$errors->hasErrors()) {
                        $registerStudentForm->setStudentPassword();

                        $this->studentGateway->updateStudent($registerStudentForm->getStudent());

                        $success = true;
                    }
                }

                include __DIR__ . '/../../templates/edit.phtml';
            }
        } else {
            Helper::redirect();
        }
    }

}
