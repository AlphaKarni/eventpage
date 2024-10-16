<?php

namespace App\Model\Mapper;

use App\Model\DTOs\UserDTO;

class UserMapper
{
    public function getUserDTO(array $user): UserDTO
    {
        return new UserDTO
        (
            $user["username"],
            $user["email"],
            $user["password"]
        );
    }
    public function getUserArray($username, $email, $password): array
    {
        return [
            "username" => $username,
            "email" => $email,
            "password" => $password,
        ];
    }
}
