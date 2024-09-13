<?php declare(strict_types=1);

namespace App\Model;

use App\Model\DTOs\EventDTO;

class EventEntityManager
{
    public function joinEvent(array $events, int $eevent, string $eventFilePath): void
    {
        $events[$eevent]["joinedPers"]++;
        $events[$eevent]["joinedUserUsernames"][] = $_SESSION["username"];
        $this->saveEvents($events, $eventFilePath);
        header('Location: /index.php?details=' . $eevent);
    }
    public function leaveEvent(array $events, int $eevent, string $eventFilePath): void
    {
        $events[$eevent]["joinedPers"]--;
        $key = array_search($_SESSION["username"], $events[$eevent]["joinedUserUsernames"], true);
        unset($events[$eevent]["joinedUserUsernames"][$key]);
        $this->saveEvents($events, $eventFilePath);
        header('Location: /index.php?details=' . $eevent);
    }
    public function saveEvents(array $events, string $eventFilePath): void
    {
        file_put_contents($eventFilePath, json_encode($events, JSON_PRETTY_PRINT));
    }
    public function deleteEvent(array $events, string $eventFilePath, int $deleteEvent): void
    {
        unset($events[$deleteEvent]);
        $this->saveEvents($events, $eventFilePath);
    }
}
