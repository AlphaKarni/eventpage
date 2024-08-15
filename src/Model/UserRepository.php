<?php

namespace App\Model;

class UserRepository
{
    public function findByEmail($checkmail,$json_file): array
    {
        $users = json_decode(file_get_contents($json_file), true);

        foreach ($users as $luser) {
            if ($luser['email'] === $checkmail) {
                return $luser;
            }
        }
        return [];
    }
}