<?php
namespace App\Model\Helper;

class RegistrationHelper
{
    public function getPost()
    {
        $post = null;

        foreach ($_POST as $key => $value) {
            $post[$key] = is_scalar($value) ? $value : '';
            $post[$key] = trim($value);
        }

        return $post;
    }

    public function redirect()
    {
        if (isset($_GET['go'])) {
            $location = $_GET['go'];

            if (preg_match('!^/([^/]|\\Z)!', $location, $matches)) {
                header("Location: " . $location);
            }
        }
    }
}
