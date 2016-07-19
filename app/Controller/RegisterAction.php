<?php
namespace App\Controller;

use App\Model\Gateway\StudentGateway;
use App\Model\Entity\Forms\RegisterStudentForm;
use App\Model\Validators\RegisterStudentFormValidations;
use App\Model\Errors\ErrorList;
use App\Model\Entity\Student;
use App\Model\Helper\Helper;
use App\Controller\LoginAction;
use App\Model\Helper\LoginHelper;
use App\View\Viewer;

class RegisterAction extends Controller
{
    protected $studentGateway;
    protected $validations;
    protected $loginAction;
    protected $helper;
    protected $loginHelper;
    protected $viewer;

    public function __construct(StudentGateway $studentGateway, RegisterStudentFormValidations $validations, LoginAction $loginAction, Helper $helper, LoginHelper $loginHelper, Viewer $viewer)
    {
        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
        $this->loginAction = $loginAction;
        $this->helper = $helper;
        $this->loginHelper = $loginHelper;
        $this->viewer = $viewer;
    }

    public function register()
    {
        $token = $this->helper->createToken();

        $logged = $this->loginHelper->isLoggedIn();

        $registerStudentForm = new RegisterStudentForm();

        if ($logged) {            
            $registerStudentForm->setStudent($logged);
        }

        $errors = new ErrorList;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $registerStudentForm->fillDataFromArray($_POST);

            $errors = $this->validations->validRegisterStudentForm($registerStudentForm, $logged); // $logged - $editMode

            if (!$errors->hasErrors()) {
                if ($this->helper->validToken($registerStudentForm->getToken())) {
                    if ($logged) {
                        $this->studentGateway->updateStudent($registerStudentForm->getStudent());

                        if ($registerStudentForm->getPassword != "") {
                            $this->loginHelper->createCookies($registerStudentForm->getStudent());
                        }
                        
                        $this->redirect('/public/index.php?notify=Success');
                    } else {
                        $this->studentGateway->addStudent($registerStudentForm->getStudent());

                        $this->loginAction->login();

                        $this->redirect($this->getQuery('go'));
                    } 
                } else {
                    throw new \Exception("Invalid token");
                }
            }
        }

        $this->viewer->render('templates/registration.phtml', compact('registerStudentForm', 'errors', 'token', 'logged'));
    }
}