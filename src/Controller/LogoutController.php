<?php

namespace App\Controller;

class LogoutController
{
    function loadLogout(): void{
            session_destroy();
            header('Location: '."http://localhost:8000/index.php");
    }
}