<?php
namespace App\Controller;


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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        }

        include __DIR__ . '/../../templates/login.phtml';
    }

}
