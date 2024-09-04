<?php

namespace App\Model;

class UserRepository
{
    public function findByEmail($checkmail, $userFilePath): array
    {

        $users = json_decode(file_get_contents($userFilePath), true);

        foreach ($users as $luser) {
            if ($luser['email'] === $checkmail) {
                return $luser;
            }
        }
        return [];
    }
    public function findByUsername($checkusername, $userFilePath): array
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