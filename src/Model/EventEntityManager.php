<?php declare(strict_types=1);

namespace App\Model;

use App\Database\Database;
use App\Model\DTOs\EventDTO;

class EventEntityManager
{
    public function joinEvent(array $event): void
    {
        $db = new Database;
        $eventid = $event['id'];

        $crntPeople = $event['crntPeople'];
        $crntPeople++;
        $query = "UPDATE Event.Events SET crntPeople = $crntPeople WHERE eventID = $eventid";
        $db->executeDML($query,[]);

        $username = $_SESSION["username"];
        $query = "INSERT INTO Event.Participants (eventID, username) VALUES ($eventid,'$username')";
        $db->executeDML($query,[]);
    }
    public function leaveEvent(array $event): void
    {
        $db = new Database;
        $eventid = $event['id'];

        $crntPeople = count($event['crntPeople']);
        $crntPeople--;
        $query = "UPDATE Event.Events SET crntPeople = $crntPeople WHERE eventID = $eventid";
        $db->executeDML($query,[]);

        $username = $_SESSION["username"];
        $query = "DELETE FROM Event.Participants WHERE username = '$username' AND eventID = 'id'";
        $db->executeDML($query,[]);
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
