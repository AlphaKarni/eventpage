<?php

namespace App\Model\DTOs;

class EventDTO
{
    public function __construct(
        public string $name,
        public string $date,
        public string $desc,
        public int $maxPers,
        public int $id,
        public int $joinedPers,
        public array $joinedUserUsernames = []
    ) {
    }
}