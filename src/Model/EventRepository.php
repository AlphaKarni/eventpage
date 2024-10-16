<?php declare(strict_types=1);

namespace App\Model;
use App\Database\Database;

class EventRepository
{
    public function __construct(
        public Database $db,
    ){}
    public function fetchAllEvents(): array
    {
        $query = "SELECT * FROM Event.Events";
        return $this->db->select($query);
    }
    public function fetchEvent($eventID): array
    {
        $query = "SELECT * FROM Event.Events WHERE eventID = '$eventID'";
        return $this->db->select($query);
    }
    public function saveEvent($event): void
    {
        $query = "INSERT INTO Event.Events (name, date, description, maxPeople) VALUES (?, ?, ?, ?)";
        $params =
            [
                ':name' => $event->name,
                ':date' => $event->date,
                ':description' => $event->description,
                ':maxPeople' => $event->maxPeople,
            ];
        $this->db->executeDML($query, $params);
    }
}