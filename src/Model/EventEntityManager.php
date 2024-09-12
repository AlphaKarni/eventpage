<?php declare(strict_types=1);

namespace App\Model;

class EventEntityManager
{
    public function joinEvent(array $events, int $eevent, string $eventFilePath): void
    {
        $events[$eevent]["joined_pers"]++;
        $events[$eevent]["joined_user_usernames"][] = $_SESSION["username"];
        $this->saveEvents($events, $eventFilePath);
        header('Location: /index.php?details=' . $eevent);
    }
    public function leaveEvent(array $events, int $eevent, string $eventFilePath): void
    {
        $events[$eevent]["joined_pers"]--;
        $key = array_search($_SESSION["username"], $events[$eevent]["joined_user_usernames"], true);
        unset($events[$eevent]["joined_user_usernames"][$key]);
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
