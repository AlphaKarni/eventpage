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

    public function loadLogin(string $userFilePath): void
    {
        $_SESSION["logged_in"] = false;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $checkmail = htmlspecialchars($_POST['email']);
            $luser = $this->userRepository->findByEmail($checkmail, $userFilePath);
            if (!empty($luser)) {
                $password = $_POST['password'];
                if (password_verify($password, $luser->password)) {
                    $_SESSION["logged_in"] = true;
                    $_SESSION['username'] = $luser->username;
                    $_SESSION['email'] = $luser->email;

                    header('Location: /index.php');
                    exit();
                } else {
                    $perror = true;
                    $this->view->addParameter('perror', $perror);
                }
            } else {
                $eerror = true;
                $this->view->addParameter('eerror', $eerror);
            }
        }

        $this->view->display(__DIR__ . '/../View/login.latte');
    }
}
