<?php
namespace App\Model\Validators;

use App\Model\Gateway\StudentGateway;

class Validations
{
    protected $studentGateway;

    public function __construct(StudentGateway $studentGateway)
    {
        $this->studentGateway = $studentGateway;
    }

    public function validLenght($string, $minLenght, $maxLenght)
    {
        $error = "";

        if (mb_strlen($string) < $minLenght) {
            $error = "It is too small min characters is $minLenght";
        } else if (mb_strlen($string) > $maxLenght) {
            $error = "It is too big max characters is $maxLenght";
        }

        return $error;
    }
}
