<?php

use Model\UserEntityManager;
use Model\UserRepository;

session_start();

require_once __DIR__ . '/../Model/UserRepository.php';
require_once __DIR__ . '/../Model/UserEntityManager.php';

class RegistrationController
{
    private UserRepository $userRepository;
    private UserEntityManager $userEntityManager;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->userEntityManager = new UserEntityManager();
    }

    public function loadRegistration($latte): void
    {
        $users = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = htmlspecialchars($_POST['username']);
            $checkmail = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $json_file = __DIR__. "/../../user.json";

            $luser = $this->userRepository->findByEmail($checkmail,$json_file);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $user_data = [
                'username' => $username,
                'email' => $checkmail,
                'password' => $hashed_password,
            ];
            if (empty($luser)) {
                $user_json = file_get_contents($json_file);
                $users = json_decode($user_json,true);
                $users[] = $user_data;
                $this->userEntityManager->save($users,$json_file);
                header('Location: ' . "http://localhost:8000/index.php/?page=login");
            } else {
                echo "<p style ='color:red'>Email already registered</p>";
            }
        }
        $params = [];
        $latte->render(__DIR__ . '/../View/user.latte', $params);
    }
}