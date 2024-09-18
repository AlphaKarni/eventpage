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


            $userDTO = $this->userMapper->getUserDTO($user_data);

            $_SESSION["emailalreadyregistered"] = !empty($luseremail);
            $_SESSION["usernamealreadyregistered"] = !empty($luserusername);

            if (!$_SESSION["emailalreadyregistered"] && !$_SESSION["usernamealreadyregistered"]) {
                $users_json = file_get_contents($userFilePath);
                $users = json_decode($users_json, true);
                $users[] = $userDTO;
                $this->userEntityManager->saveUsers($users, $userFilePath);
                header('Location: /index.php?page=login');
                exit();
            }
        }
        $this->view->display(__DIR__ . '/../View/user.latte');
    }
}
