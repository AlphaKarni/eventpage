<?php

namespace App\Model\Mapper;

use App\Model\DTOs\EventDTO;

class EventMapper
{
    public function getEventDTO(array $events): EventDTO
    {
        return new EventDTO(
            $events["Name"],
            $events["Date"],
            $events["Description"],
            $events["CrntPeople"],
            $events["MaxPeople"],
        );
    }
}
