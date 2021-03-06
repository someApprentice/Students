<?php
namespace App\Controller;

use App\Model\Gateway\StudentGateway;
use App\Model\Validators\LoginStudentFormValidations;
use App\Model\Helper\Helper;
use App\Model\Helper\LoginHelper;
use App\Model\Entity\Forms\LoginStudentForm;
use App\Model\Errors\ErrorList;
use App\Model\Entity\Student;

class LoginAction extends Controller
{
    protected $studentGateway;
    protected $validations;
    protected $helper;
    protected $loginHelper;

    public function __construct(StudentGateway $studentGateway, LoginStudentFormValidations $validations, Helper $helper, LoginHelper $loginHelper)
    {
        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
        $this->helper = $helper;
        $this->loginHelper = $loginHelper;
    }

    public function login()
    {
        $token = $this->helper->createToken();

        $loginStudentForm = new LoginStudentForm();

        $errors = new ErrorList();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loginStudentForm->fillDataFromArray($_POST);

            $errors = $this->validations->validLoginStudentForm($loginStudentForm);

            if (!$errors->hasErrors()) {
                if ($this->helper->validToken($token)) {
                    $student = $this->studentGateway->getStudentByСolumn('email', $loginStudentForm->getEmail());

                    if ($student and $this->loginHelper->isPasswordValid($student, $loginStudentForm->getPassword())) {
                        $this->loginHelper->createCookies($student);

                        $this->redirect($this->getQuery('go'));

                        exit();
                    } else {
                        $errors->setError('login', "Incorrect username or password");
                    }
                } else {
                    throw new \Exception("Invalid token");
                }
            }
        }

        $this->render('templates/login.phtml', compact('loginStudentForm', 'errors', 'token'));
    }

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->helper->validToken($_POST['token']) and $this->loginHelper->isLoggedIn()) {
                    $this->loginHelper->deleteCookies();
            }

            $this->redirect($this->getQuery('go'));
        }
    }
}