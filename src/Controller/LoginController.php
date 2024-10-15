<?php

namespace App\Controller;

use App\Core\ViewInterface;
use App\Model\UserRepository;

class LoginController
{

    public function __construct
    (
        public UserRepository $userRepository,
        public ViewInterface $view
    ) {}

    public function loadLogin(): void
    {
        $_SESSION["loggedIn"] = false;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $checkmail = htmlspecialchars($_POST['email']);
            $luser = $this->userRepository->fetchByEmail($checkmail);
            if (!empty($luser)) {
                $password = $_POST['password'];
                if (password_verify($password, $luser->password)) {
                    $_SESSION["loggedIn"] = true;
                    $_SESSION['username'] = $luser->username;
                    $_SESSION['email'] = $luser->email;

                    header('Location: /index.php');
                    exit();
                } else {
                    $this->view->addParameter('perror', true);
                }
            } else {
                $this->view->addParameter('eerror', true);
            }
        }

        $this->view->display(__DIR__ . '/../View/login.latte');
    }
}
