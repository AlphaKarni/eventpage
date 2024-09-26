<?php

namespace App\Controller;
class LogoutController
{
    public function loadLogout(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /index.php');
    }
}
