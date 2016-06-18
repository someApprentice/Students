<?php
namespace App\Controller;

use App\Model\Gateway\StudentGateway;
use App\Model\Entity\RegisterStudentForm;
use App\Model\Validators\RegisterStudentFormValidations;
use App\Model\Errors\ErrorList;
use App\Model\Entity\Student;
use App\Model\Helper\Helper;
use App\Controller\LoginAction;
use App\Model\Cookies\StudentCookies;

class RegisterAction
{
    protected $studentGateway;
    protected $validations;
    protected $loginAction;
    protected $studentCookies;

    public function __construct(StudentGateway $studentGateway, RegisterStudentFormValidations $validations, LoginAction $loginAction, $studentCookies)
    {
        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
        $this->loginAction = $loginAction;
        $this->studentCookies = $studentCookies;
    }

    public function register()
    {

        $registerStudentForm = new RegisterStudentForm();

        if (Helper::validCSRFtoken($_GET['token']) and $this->loginAction->isLoggedIn()) {
            $student = $this->studentGateway->getStudentByСolumn('id', $_COOKIE['id']);
            $registerStudentForm->setStudent($student);
        }

        $errors = new ErrorList;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $registerStudentForm->fillDataFromArray($_POST);

            if (Helper::validCSRFtoken($_GET['token']) and $this->loginAction->isLoggedIn()) {
                $errors = $this->validations->validRegisterStudentForm($registerStudentForm, true); // true - $editMode
            } else {
                $errors = $this->validations->validRegisterStudentForm($registerStudentForm);
            }      

            if (!$errors->hasErrors()) {
                if (Helper::validCSRFtoken($_GET['token']) and $this->loginAction->isLoggedIn()) {
                    if ($registerStudentForm->getPassword() != "") {
                        $registerStudentForm->setStudentPassword();

                        $this->studentGateway->updateStudent($registerStudentForm->getStudent());

                        $this->studentCookies->createCookies($registerStudentForm->getStudent());
                    } else {
                        $this->studentGateway->updateStudent($registerStudentForm->getStudent());
                    }
                    
                    Helper::redirect('/public/index.php?notify=Success');
                } else {
                    $registerStudentForm->setStudentPassword();

                    $this->studentGateway->addStudent($registerStudentForm->getStudent());

                    $this->loginAction->login();

                    Helper::redirect($_GET['go']);
                }  
            }
        }

        include __DIR__ . '/../../templates/registration.phtml';
    }
}