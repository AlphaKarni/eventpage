<?php declare(strict_types=1);

namespace App\Model;

class EventRepository
{
    public function findAllEvents($eventFilePath): array
    {
        if ($this->fileExists($eventFilePath)) {
            return $this->loadEvents($eventFilePath);
        }
        return [];
    }

    public function fileExists($eventFilePath): bool
    {
        return file_exists($eventFilePath);
    }

    public function loadEvents($eventFilePath): array
    {
        return json_decode(file_get_contents($eventFilePath), true);
    }
}