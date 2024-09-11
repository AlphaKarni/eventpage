<?php

namespace App\Controller;

use App\Core\ViewInterface;

class LogoutController
{
    private ViewInterface $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function loadLogout(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /index.php');
        exit();
    }
}
