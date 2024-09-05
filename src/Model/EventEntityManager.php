<?php declare(strict_types=1);

namespace App\Model;

class EventEntityManager
{
    public function joinEvent($events,$eevent, $eventFilePath)
    {
        $events[$eevent]["joined_pers"]++;
        $events[$eevent]["joined_user_usernames"][] = $_SESSION["username"];
        $this->saveEvents($events,$eventFilePath);
    }
    public function leaveEvent($events,$eevent, $eventFilePath)
    {
        $events[$eevent]["joined_pers"]--;
        $key = array_search($_SESSION["username"], $events[$eevent]["joined_user_usernames"], true);
        unset ($events[$eevent]["joined_user_usernames"][$key]);
        $this->saveEvents($events,$eventFilePath);
    }
    public function saveEvents($events, $eventFilePath)
    {
        file_put_contents($eventFilePath, json_encode($events, JSON_PRETTY_PRINT));
        header('Location: '."http://localhost:8000/index.php");
    }
    public function deleteEvent($events,$eventFilePath,$deleteEvent)
    {
        unset ($events[$deleteEvent]);
        $this->saveEvents($events,$eventFilePath);
    }
}
