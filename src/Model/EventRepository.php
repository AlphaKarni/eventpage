<?php
declare(strict_types=1);

namespace App\Model;

class EventRepository
{
    public function findAllEvents(string $eventFilePath): array
    {
        if ($this->fileExists($eventFilePath)) {
            return $this->loadEvents($eventFilePath);
        }
        return [];
    }

    public function fileExists(string $eventFilePath): bool
    {
        return file_exists($eventFilePath);
    }

    public function loadEvents(string $eventFilePath): array
    {
        return json_decode(file_get_contents($eventFilePath), true);
    }

    public function fetchAllEvents(): array
    {
        $sqlConnector = new SQLConnector
        (
            "mysql:host=localhost;dbname=event_calendar",
            "your_username",
            "your_password"
        );
        $res = $sqlConnector->query('SELECT * FROM event_calendar where :name = name', ['']);
        return $res;
    }
}
