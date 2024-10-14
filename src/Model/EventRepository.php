<?php
declare(strict_types=1);

namespace App\Model;
use App\Database\Database;

class EventRepository
{
    public function fetchAllEvents(): array
    {
        $db = new Database();
        $query = "SELECT * FROM Event.Events";
        return $db->select($query);
    }
    public function saveEvent($event): void
    {
        $db = new Database();
        $query = "INSERT INTO Event.Events (name, date, description, maxPeople) VALUES (:name, :date, :description, :maxPeople)";
        $params =
            [
                ':name' => $event->name,
                ':date' => $event->date,
                ':description' => $event->description,
                ':maxPeople' => $event->maxPeople,
            ];
        $db->executeDML($query, $params);
    }
    public function fetchParticipants($eventID): array
    {
        $db = new Database();
        $query = "SELECT * FROM Event.Participants WHERE eventID = '$eventID'";
        return $db->select($query);
    }
}