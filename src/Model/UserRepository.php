<?php

namespace App\Model;

class UserRepository
{
    public function findByEmail($checkmail): array
    {
        $json_file = __DIR__ . '/../../user.json';

        $users = json_decode(file_get_contents($json_file), true);

        foreach ($users as $luser) {
            if ($luser['email'] === $checkmail) {
                return $luser;
            }
        }
        return [];
    }
    public function findByUsername($checkusername): array
    {
        $json_file = __DIR__ . '/../../user.json';

        $users = json_decode(file_get_contents($json_file), true);
        foreach ($users as $luser) {
            if ($luser['username'] === $checkusername) {
                return $luser;
            }
        }
        return [];
    }
}