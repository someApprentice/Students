<?php
namespace App\Controller;

use App\Model\Gateway\StudentGateway;
use App\Model\Validators\LoginStudentFormValidations;
use App\Model\Helper\LoginHelper;
use App\Model\Entity\LoginStudentForm;
use App\Model\Errors\ErrorList;
use App\Model\Entity\Student;
use App\Model\Cookies\StudentCookies;

class LoginAction
{
    protected $studentGateway;
    protected $validations;
    protected $loginHelper;
    protected $studentCookies;

    public function __construct(StudentGateway $studentGateway, LoginStudentFormValidations $validations, LoginHelper $loginHelper, StudentCookies $studentCookies)
    {
        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
        $this->loginHelper = $loginHelper;
        $this->studentCookies = $studentCookies;
    }

    public function isLoggedIn()
    { 
        if (isset($_COOKIE['id'])) {
            $student = $this->studentGateway->getStudentByСolumn('id', $_COOKIE['id']);

            if ($this->loginHelper->validCSRFtoken($student->getToken())) {

                return true;
            }
        }

        return false;
    }

    public function login()
    {
        $loginStudentForm = new LoginStudentForm();

        $errors = new ErrorList();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loginStudentForm->fillDataFromArray($_POST);

            $errors = $this->validations->validLoginStudentForm($loginStudentForm);

            if (!$errors->hasErrors()) {
                $student = $this->studentGateway->getStudentByСolumn('email', $loginStudentForm->getEmail());

                if ($student and $this->loginHelper->isPasswordValid($student, $loginStudentForm->getPassword())) {
                    $this->studentCookies->createCookies($student);

                    $this->loginHelper->redirect($_GET['go']);

                    exit();
                } else {
                    $errors->setError('login', "Incorrect username or password");
                }
            }
        }

        include __DIR__ . '/../../templates/login.phtml';
    }

    public function logout() {
        if ($this->loginHelper->validCSRFtoken($_GET['token']) and $this->isLoggedIn()) {
                $this->studentCookies->deleteCookies();
        }

        $this->loginHelper->redirect($_GET['go']);
    }
}