<?php
namespace App\Controller;

use App\Model\Helper\LoginHelper as Authorizer;
use App\Model\Gateway\StudentGateway;
use App\Model\Entity\RegisterStudentForm;
use App\Model\Validators\RegisterStudentFormValidations;
use App\Model\Errors\ErrorList;
use App\Model\Entity\Student;

class RegisterAction
{
    protected $authorizer;
    protected $studentGateway;
    protected $validations;

    public function __construct(Authorizer $authorizer, StudentGateway $studentGateway, RegisterStudentFormValidations $validations)
    {
        $this->authorizer = $authorizer;
        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
    }

    public function register()
    {
        $registerStudentForm = new RegisterStudentForm();

        $errors = new ErrorList;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $registerStudentForm->fillDataFromArray($_POST);

            $errors = $this->validations->validRegisterStudentForm($registerStudentForm);

            if (!$errors->hasErrors()) {
                $registerStudentForm->setStudentPassword($this->authorizer);

                $this->studentGateway->addStudent($registerStudentForm->getStudent());

                //login

                $this->authorizer->redirect($_GET['go']);
            }
        }

        include __DIR__ . '/../../templates/registration.phtml';
    }

}
