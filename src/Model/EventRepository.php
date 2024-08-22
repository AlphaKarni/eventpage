<?php

namespace App\Model;

class EventRepository
{
    public function findAllEvents(): array
    {
        $json_file = __DIR__ . '/../../events.json';
        if (file_exists($json_file)) {
            return json_decode(file_get_contents($json_file), true);
        }
        return [];
    }
}