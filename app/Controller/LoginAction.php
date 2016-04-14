<?php
namespace App\Controller;

use App\Model\Entity\LoginStudentForm;
use App\Model\Entity\Student;
use App\Model\Gateway\StudentGateway;

use App\Model\Validators\Validations;

class LoginAction
{

    protected $studentGateway;
    protected $validations;

    public function __construct(StudentGateway $studentGateway, Validations $validations)
    {

        $this->validations = $validations;
        $this->studentGateway = $studentGateway;
    }

    public function login()

        $loginStudentForm = new LoginStudentForm();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loginStudentForm->setLogin();
            $loginStudentForm->setPassword();

            $loginStudentForm->setErrors($this->validations->validateLoginStudentForm($loginStudentForm));

            if (!count(array_filter($registerStudentForm->getErrors()))) {
                $student['email'] = $studentGateway->getStudentByСolumn('email', $loginStudentForm->getLogin());
                $student['surname'] = $studentGateway->getStudentByСolumn('surname', $loginStudentForm->getLogin());
                $student['name'] = $studentGateway->getStudentByСolumn('name', $loginStudentForm->getLogin());                

                //Проходимся по каждому возможному соответсвию хэша из БД и хэша из формы, и если оно есть, то останавливаем цикл и используем эту сущность для работы дальше.
                //Иначе удаляем её из массива, и если сущностей (больше) нет, то возвращеаем ошибку
                foreach ($student as $key => $value) {
                    if (!count(array_filter($student))) {
                        if ($value->getHash() == $value->hashPassword($loginStudentForm->getPassword(), $value->getSalt())) {
                            $student = $value;

                            //cookies

                            $_SESSION['id'] = $student->getId();
                            $_SESSION['name'] = $student->getName();
                            $_SESSION['surname'] = $student->getSurname();
                            $_SESSION['token'] = $student->getToken();
                            
                            //redirect

                            break;
                        } else {
                            unset($student[$key]);
                        }
                    } else {
                        $loginStudentForm->getError('login', "Incorrect username or password")
                    }
                }
            }
        }

        include __DIR__ . '/../../templates/login.phtml';
    }

}
