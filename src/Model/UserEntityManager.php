<?php declare(strict_types=1);

namespace App\Model;

class UserEntityManager
{
    public function saveUsers(array $users, string $userFilePath): void
    {
        file_put_contents($userFilePath, json_encode($users, JSON_PRETTY_PRINT));
    }
}
