<?php

namespace App\Model\Mapper;

use App\Model\DTOs\eventDTO;

class EventMapper
{
    public function getEventDTO(array $events): eventDTO
    {
        return new eventDTO(
            $events["name"],
            $events["date"],
            $events["desc"],
            $events["maxPers"],
            $events["id"],
            $events["joinedPers"]
        );
    }
    public function getEventsArray(eventDTO $eventDTO): array
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
