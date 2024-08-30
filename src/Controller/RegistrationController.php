<?php

namespace App\Controller;

use App\Model\UserEntityManager;
use App\Model\UserRepository;


class RegistrationController
{
    private UserRepository $userRepository;
    private UserEntityManager $userEntityManager;

    private $filePath;
    public function __construct($filePath = null)
    {
        $this->filePath = $filePath ?? __DIR__ . '/../../user.json';
        $this->userRepository = new UserRepository();
        $this->userEntityManager = new UserEntityManager();
    }
    public function loadRegistration($latte): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $checkusername = htmlspecialchars($_POST['username']);
            $checkmail = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $luseremail = $this->userRepository->findByEmail($checkmail);
            $luserusername = $this->userRepository->findByUsername($checkusername);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $user_data = [
                'username' => $checkusername,
                'email' => $checkmail,
                'password' => $hashed_password,
                'joined_events' => []
            ];
            $emailregistered = true;
            $usernameregistered = true;

            if (empty($luseremail)) {
                $emailregistered = false;
            } else {
                $_SESSION['displayemailregistered'] = true;
            }

            if (empty($luserusername)) {
                $usernameregistered = false;
            } else {
                $_SESSION['displayusernameregistered'] = true;
            }

            if (($emailregistered) === false && ($usernameregistered === false)) {
                $user_json = file_get_contents($this->filePath);
                $users = json_decode($user_json,true);
                $users[] = $user_data;
                $this->userEntityManager->save($users,$this->filePath);
               header('Location: ' . "http://localhost:8000/index.php/?page=login");
            }
        }
        $params = [];
        $latte->render(__DIR__ . '/../View/user.latte', $params);
    }
}