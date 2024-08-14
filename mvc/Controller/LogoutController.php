<?php

class LogoutController
{
    function loadLogout(): void{
        if ($_GET["page"] === "logout") {
            session_destroy();
            header('Location: '."http://localhost:8000/index.php");
        }
    }
}