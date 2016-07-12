<?php
namespace App\Controller;

use App\Model\Gateway\StudentGateway;
use App\Model\Validators\LoginStudentFormValidations;
use App\Model\Helper\LoginHelper;
use App\Model\Entity\Forms\LoginStudentForm;
use App\Model\Errors\ErrorList;
use App\Model\Entity\Student;
use App\View\Viewer;

class LoginAction extends Controller
{
    protected $studentGateway;
    protected $validations;
    protected $loginHelper;
    protected $viewer;

    public function __construct(StudentGateway $studentGateway, LoginStudentFormValidations $validations, LoginHelper $loginHelper, Viewer $viewer)
    {
        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
        $this->loginHelper = $loginHelper;
        $this->viewer = $viewer;
    }

    public function login()
    {
        $token = $this->loginHelper->createToken();

        $loginStudentForm = new LoginStudentForm();

        $errors = new ErrorList();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loginStudentForm->fillDataFromArray($_POST);

            $errors = $this->validations->validLoginStudentForm($loginStudentForm);

            if (!$errors->hasErrors()) {
                if ($this->loginHelper->validToken($token)) {
                    $student = $this->studentGateway->getStudentByСolumn('email', $loginStudentForm->getEmail());

                    if ($student and $this->loginHelper->isPasswordValid($student, $loginStudentForm->getPassword())) {
                        $this->loginHelper->createCookies($student);

                        $this->loginHelper->redirect($this->getQuery('go'));

                        exit();
                    } else {
                        $errors->setError('login', "Incorrect username or password");
                    }
                } else {
                    throw new Exception("Invalid token");
                }
            }
        }

        $this->viewer->render('templates/login.phtml', compact('loginStudentForm', 'errors', 'token'));
    }

    public function logout() {
        if ($this->loginHelper->validToken($_GET['token']) and $this->loginHelper->isLoggedIn()) {
                $this->loginHelper->deleteCookies();
        }

        $this->loginHelper->redirect($this->getQuery('go'));
    }
}