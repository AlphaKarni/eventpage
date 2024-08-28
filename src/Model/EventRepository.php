<?php

namespace App\Model;

class EventRepository
{
    public function findAllEvents($json_file): ?array
    {
        if (file_exists($json_file)) {
            return json_decode(file_get_contents($json_file), true);
        }
        return null;
    }
}