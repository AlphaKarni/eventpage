<?php

namespace App\Model;

class UserEntityManager
{
    function saveUsers($users, $userFilePath): void
    {
        file_put_contents($userFilePath, json_encode($users, JSON_PRETTY_PRINT));
    }
}