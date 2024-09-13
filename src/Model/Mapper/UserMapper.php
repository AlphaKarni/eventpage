<?php

namespace App\Model\Mapper;

use App\Model\DTOs\EventDTO;

class UserMapper
{
    public function getEventDTOs(array $events): EventDTO{
        return new EventDTO($events);

    }
}
