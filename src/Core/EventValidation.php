<?php

namespace App\Core;

use App\Model\DTOs\EventDTO;

class EventValidation
{
    public function validateEvent(array $events, EventDTO $eventDTO): array
    {
        $errors = [
            "nameerror" => false,
            "descerror" => false,
            "maxperserror" => false,
            "dateerror" => false,
        ];

        if (strlen(trim($eventDTO->name)) < 3) {
            $errors["nameerror"] = true;
        }

        if (strlen(trim($eventDTO->desc)) < 5) {
            $errors["descerror"] = true;
        }

        if (!is_numeric($eventDTO->maxPers) || $eventDTO->maxPers <= 1) {
            $errors["maxperserror"] = true;
        }

        $currentDate = new \DateTime();
        $eventDate = \DateTime::createFromFormat('Y-m-d', $eventDTO->date);

        if ($eventDate < $currentDate) {
            $errors["dateerror"] = true;
        }

        if (!array_filter($errors)) {
            $events[] = $eventDTO;
            return $events;
        }

        return $errors;
    }
}
