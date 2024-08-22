<?php

namespace App\Model;

class UserEntityManager
{
    function save($users,$json_file): void
    {

        file_put_contents($json_file, json_encode($users, JSON_PRETTY_PRINT));
    }
}