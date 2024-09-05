<?php

namespace App\Controller;

use App\Model\UserEntityManager;
use App\Model\UserRepository;


class RegistrationController
{
    public UserRepository $userRepository;
    public UserEntityManager $userEntityManager;
    public function __construct($userFilePath = null)
    {
        $this->userRepository = new UserRepository();
        $this->userEntityManager = new UserEntityManager();
    }
    public function loadRegistration($latte, $userFilePath): void
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

            $_SESSION["emailalreadyregistered"] = false;
            $_SESSION["usernamealreadyregistered"] = false;

            if (!empty($luseremail)) {
                $_SESSION['emailalreadyregistered'] = true;
            }

            if (!empty($luserusername)) {
                $_SESSION['usernamealreadyregistered'] = true;
            }

            if (($_SESSION["emailalreadyregistered"]) === false && ($_SESSION["usernamealreadyregistered"] === false)) {
                $user_json = file_get_contents($userFilePath);
                $users = json_decode($user_json,true);
                $users[] = $user_data;
                $this->userEntityManager->saveUsers($users,$userFilePath);
               header('Location: ' . "http://localhost:8000/index.php/?page=login");
            }
        }
        $params = [];
        $latte->render(__DIR__ . '/../View/user.latte', $params);
    }
}