<?php

namespace App\Model;

class EventEntityManager
{
    private $filePath;
    public function __construct($filePath = null)
    {
        $this->filePath = $filePath ?? __DIR__ . '/../../events.json';
    }
    public function joinEvent($events,$eevent): void
    {
        $events[$eevent]["joined_pers"]++;
        $events[$eevent]["joined_user_usernames"][] = $_SESSION["username"];
        $this->saveEvents($events);
    }
    public function leaveEvent($events,$eevent): void
    {
        $events[$eevent]["joined_pers"]--;
        $key = array_search($_SESSION["username"], $events[$eevent]["joined_user_usernames"], true);
        unset ($events[$eevent]["joined_user_usernames"][$key]);
        $this->saveEvents($events);
    }
    public function saveEvents($events): void
    {
        file_put_contents($this->filePath, json_encode($events, JSON_PRETTY_PRINT));
        header('Location: '."http://localhost:8000/index.php");
    }
}
