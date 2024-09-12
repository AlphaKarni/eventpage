<?php

namespace App\Model\Mapper;

use App\Model\DTOs\eventDTO;

class UserMapper
{
    public function getEventDTOs(array $events): eventDTO{
        return new eventDTO($events);

    }
}
