<?php
declare(strict_types=1);

namespace App\Model;
use App\Database\Database;
use App\Model\DTOs\EventDTO;
use App\Model\Mapper\EventMapper;

class EventRepository
{
    public function fetchAllEvents(): array
    {
        $db = new Database();
        $query = "SELECT * FROM Event.Events";
        return $db->select($query,[]);
    }
    public function saveEvent($event): void
    {
        $db = new Database();
        $query = "INSERT INTO Event.Events (Name, Date, Description, CrntPeople, MaxPeople) VALUES (:name, :date, :description, :crntPeople, :maxPeople)";
        $params =
            [
                ':name' => $event->name,
                ':date' => $event->date,
                ':description' => $event->description,
                ':crntPeople' => $event->crntPeople,
                ':maxPeople' => $event->maxPeople,
            ];
        $db->executeDML($query, $params);
    }
}
