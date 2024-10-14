<?php

namespace App\Model\DTOs;

class EventDTO
{
    public function __construct(
        public string $name,
        public string $date,
        public string $description,
        public int $maxPeople,
    ) {
    }
}