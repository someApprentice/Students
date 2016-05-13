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

            if ($student->getToken() == $_COOKIE['token']) {

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
                $potentialStudents['email'] = $this->studentGateway->getStudentByСolumn('email', $loginStudentForm->getLogin());
                $potentialStudents['surname'] = $this->studentGateway->getStudentByСolumn('surname', $loginStudentForm->getLogin());
                $potentialStudents['name'] = $this->studentGateway->getStudentByСolumn('name', $loginStudentForm->getLogin());

                $potentialStudents = array_filter($potentialStudents);
               
                if (count($potentialStudents)) {
                    foreach ($potentialStudents as $potentialStudent) {
                        if ($this->loginHelper->isPasswordValid($potentialStudent, $loginStudentForm->getPassword())) {
                            $student = $potentialStudent;

                            $errors->unsetError('login');

                            $this->studentCookies->createCookies($student);

                            $this->loginHelper->redirect($_GET['go']);

                            break;
                        } else {
                            $errors->setError('login', "Incorrect username or password");

                            continue;
                        }
                    }
                } else {
                    $errors->setError('login', "Incorrect username or password");
                }
            }
        }

        include __DIR__ . '/../../templates/login.phtml';
    }

    public function logout() {
        if (isset($_GET['token']) and $this->isLoggedIn()) {
            if ($_GET['token'] == $_COOKIE['token']) {
                $this->studentCookies->deleteCookies();
            }
        }

        $this->loginHelper->redirect($_GET['go']);
    }
}