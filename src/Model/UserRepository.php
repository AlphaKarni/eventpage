<?php declare(strict_types=1);

namespace App\Model;

class UserRepository
{
    public function findByEmail(string $checkmail, string $userFilePath): array
    {
        $users = json_decode(file_get_contents($userFilePath), true);

        foreach ($users as $luser) {
            if ($luser['email'] === $checkmail) {
                return $luser;
            }
        }
        return [];
    }

    public function findByUsername(string $checkusername, string $userFilePath): array
    {
        $users = json_decode(file_get_contents($userFilePath), true);
        foreach ($users as $luser) {
            if ($luser['username'] === $checkusername) {
                return $luser;
            }
        }
        return [];
    }
}