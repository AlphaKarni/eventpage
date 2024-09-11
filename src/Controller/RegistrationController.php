<?php

namespace App\Controller;

use App\Core\ViewInterface;
use App\Model\UserRepository;
use App\Model\UserEntityManager;

class RegistrationController
{
    private UserRepository $userRepository;
    private UserEntityManager $userEntityManager;
    private ViewInterface $view;

    public function __construct(UserRepository $userRepository, UserEntityManager $userEntityManager, ViewInterface $view)
    {
        $this->userRepository = $userRepository;
        $this->userEntityManager = $userEntityManager;
        $this->view = $view;
    }

    public function loadRegistration(string $userFilePath): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $checkusername = htmlspecialchars($_POST['username']);
            $checkmail = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $luseremail = $this->userRepository->findByEmail($checkmail, $userFilePath);
            $luserusername = $this->userRepository->findByUsername($checkusername, $userFilePath);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $user_data = [
                'username' => $checkusername,
                'email' => $checkmail,
                'password' => $hashed_password
            ];

            $_SESSION["emailalreadyregistered"] = !empty($luseremail);
            $_SESSION["usernamealreadyregistered"] = !empty($luserusername);

            if (!$_SESSION["emailalreadyregistered"] && !$_SESSION["usernamealreadyregistered"]) {
                $user_json = file_get_contents($userFilePath);
                $users = json_decode($user_json, true);
                $users[] = $user_data;
                $this->userEntityManager->saveUsers($users, $userFilePath);
                header('Location: /index.php?page=login');
                exit();
            }
        }
        $this->view->display(__DIR__ . '/../View/user.latte');
    }
}
