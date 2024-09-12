<?php

namespace App\Model\DTOs;

class eventDTO
{
    public function __construct(
        public string $name,
        public string $date,
        public string $desc,
        public int $maxPers,
        public int $id,
        public int $joinedPers
    ) {
    }
}