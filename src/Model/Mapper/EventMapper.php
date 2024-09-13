<?php

namespace App\Model\Mapper;

use App\Model\DTOs\EventDTO;

class EventMapper
{
    public function getEventDTO(array $events): EventDTO
    {
        return new EventDTO(
            $events["name"],
            $events["date"],
            $events["desc"],
            $events["maxPers"],
            $events["id"],
            $events["joinedPers"],
            $events["joinedUserUsernames"]
        );
    }
    public function getEventsArray(EventDTO $eventDTO): array
    {
        return [
            "name" => $eventDTO->name,
            "date" => $eventDTO->date,
            "desc" => $eventDTO->desc,
            "maxPers" => $eventDTO->maxPers,
            "id" => $eventDTO->id,
            "joinedPers" => $eventDTO->joinedPers
        ];
    }
}
