<?php

namespace App\Model;

class EventEntityManager
{
    public function saveEvents($events,$json_file): void
    {
        file_put_contents($json_file, json_encode($events, JSON_PRETTY_PRINT));
        header('Location: '."http://localhost:8000/index.php");
    }
    public function joinEvent($events, $json_file,$eevent,): void {
        $events[$eevent]["joined_pers"]++;
        $events[$eevent]["joined_user_usernames"][] = $_SESSION["username"];
        $this->saveEvents($events,$json_file);
    }
    public function leaveEvent($events,$json_file,$eevent): void{
        $events[$eevent]["joined_pers"]--;
        $key = array_search($_SESSION["username"], $events[$eevent]["joined_user_usernames"], true);
        unset ($events[$eevent]["joined_user_usernames"][$key]);

        $this->saveEvents($events,$json_file);
    }
}
