<?php

namespace App\Controller;

use App\Model\UserRepository;

require_once __DIR__ . '/../Model/UserRepository.php';

class LoginController
{
    public UserRepository $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    function loadLogin($latte): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $checkmail = htmlspecialchars($_POST['email']);

            $json_file = __DIR__ . '/../../user.json';

            $luser = $this->userRepository->findByEmail($checkmail,$json_file);
            if (!empty($luser)) {
                $password = $_POST['password'];
                if (password_verify($password, $luser['password'])) {
                    $_SESSION["logged_in"] = true;
                    $_SESSION['username'] = $luser['username'];
                    $_SESSION['email'] = $luser['email'];

                    header('Location: ' . "http://localhost:8000/index.php");
                } else {
                    echo "Wrong password";
                }
            } else {
                echo "Email Not Found!";
            }

        }
        $params = [];
        $latte->render(__DIR__ . '/../View/login.latte', $params);
    }
}
