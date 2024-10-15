<?php

namespace App\Controller;

use App\Core\ViewInterface;
use App\Model\UserRepository;
use App\Model\UserEntityManager;
use App\Model\Mapper\UserMapper;

class RegistrationController
{
    public function __construct(
        public UserRepository $userRepository,
        public UserEntityManager $userEntityManager,
        public ViewInterface $view,
        public UserMapper $userMapper,
    ) {
    }

    public function loadRegistration(): void
    {
        $_SESSION["emailalreadyregistered"] = false;
        $_SESSION["usernamealreadyregistered"] = false;
        if ($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $checkusername = htmlspecialchars($_POST['username']);
            $checkmail = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $luser = $this->userRepository->fetchByEmail($checkmail);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $user_data = [
                'username' => $checkusername,
                'email' => $checkmail,
                'password' => $hashed_password
            ];

            $_SESSION["emailalreadyregistered"] = !empty($luser->email);
            $_SESSION["usernamealreadyregistered"] = !empty($luser->username);

            if (!$_SESSION["emailalreadyregistered"] && !$_SESSION["usernamealreadyregistered"]) {
                $this->userEntityManager->saveUser($user_data);
                header('Location: /index.php?page=login');
            }
        }
        $this->view->display(__DIR__ . '/../View/user.latte');
    }
}
