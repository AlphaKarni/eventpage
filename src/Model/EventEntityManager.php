<?php

namespace App\Model;

class EventEntityManager
{
    public function saveEvents($events): void
    {
        $json_file = __DIR__ . '/../../events.json';
        file_put_contents($json_file, json_encode($events, JSON_PRETTY_PRINT));
        header('Location: '."http://localhost:8000/index.php");
    }
    public function joinEvent($events,$eevent,): void {
        $events[$eevent]["joined_pers"]++;
        $events[$eevent]["joined_user_usernames"][] = $_SESSION["username"];
        $this->saveEvents($events);
    }
    public function leaveEvent($events,$eevent): void{
        $events[$eevent]["joined_pers"]--;
        $key = array_search($_SESSION["username"], $events[$eevent]["joined_user_usernames"], true);
        unset ($events[$eevent]["joined_user_usernames"][$key]);
        $this->saveEvents($events);
    }
}
