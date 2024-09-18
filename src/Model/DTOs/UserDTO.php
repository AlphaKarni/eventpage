<?php

namespace App\Model\DTOs;

class UserDTO
{
    public function __construct(
        public string $username,
        public string $email,
        public string $password
    ) {
    }
}