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
        $events[$eevent]["joined_user_email"] = $_SESSION["email"];
        $this->saveEvents($events,$json_file);
    }
    public function leaveEvent($events,$json_file,$eevent): void{
        $events[$eevent]["joined_pers"]--;
        $key = array_search($_SESSION["email"], $events[$eevent]["joined_user_email"]);
        unset ($events[$eevent]["joined_user_email"][$key]);

        $this->saveEvents($events,$json_file);
    }
}
