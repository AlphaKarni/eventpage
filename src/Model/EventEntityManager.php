<?php declare(strict_types=1);

namespace App\Model;

use App\Database\Database;
use App\Model\DTOs\EventDTO;

class EventEntityManager
{
    public function joinEvent(array $event): void
    {
        $db = new Database;
        $eventid = $event['eventID'];

        $username = $_SESSION["username"];
        $email = $_SESSION["email"];
        $query = "INSERT INTO Event.Participants (eventID, username, email) VALUES (?,?,?)";
        $db->executeDML($query, [$eventid, $username, $email]);
    }
    public function leaveEvent(array $event): void
    {
        $db = new Database;
        $eventid = $event['eventID'];

        $username = $_SESSION["username"];
        $query = "DELETE FROM Event.Participants WHERE username = ? AND eventID = ?";
        $db->executeDML($query,[$username, $eventid]);
    }
//    public function saveEvents(array $events): void
//    {
//        $query = "INSERT INTO Event.Participants (eventID, username) VALUES ($eventid,'$username')";
//
//    }
//    public function deleteEvent(array $events, string $eventFilePath, int $deleteEvent): void
//    {
//        unset($events[$deleteEvent]);
//        $this->saveEvents($events, $eventFilePath);
//    }
}
