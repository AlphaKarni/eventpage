<?php

namespace App\Controller;

use App\Core\ViewInterface;
use App\Model\DTOs\UserDTO;
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
        if ($_SERVER["REQUEST_METHOD"] === "POST")

        {
            $checkusername = htmlspecialchars($_POST['username']);
            $usernamefound = $this->userRepository->usernameExists(htmlspecialchars($_POST['username']));

            $checkmail = htmlspecialchars($_POST['email']);
            $emailfound = $this->userRepository->emailExists($checkmail);

            $password = htmlspecialchars($_POST['password']);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $user_data = $this->userMapper->getUserArray($checkusername, $checkmail, $hashed_password);

            $this->userMapper->getUserDTO($user_data);

            if (!$emailfound && !$usernamefound)
            {
                $this->userEntityManager->saveUser($user_data);

                $this->view->addParameter('succregistration', true);

                header('Location: /index.php?page=login');
            } else {
                if ($emailfound)
                {
                    $this->view->addParameter('emailfound', true);
                }
                if ($usernamefound)
                {
                    $this->view->addParameter('usernamefound', true);
                }
            }
        }
        $this->view->display(__DIR__ . '/../View/user.latte');
    }
}
