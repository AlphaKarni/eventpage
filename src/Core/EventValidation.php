<?php

namespace App\Core;

use App\Model\DTOs\EventDTO;

class EventValidation
{
    public function validateEvent(EventDTO $eventDTO): bool|array
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

        if (strlen(trim($eventDTO->description)) < 5) {
            $errors["descerror"] = true;
        }

        if (!is_numeric($eventDTO->maxPeople) || $eventDTO->maxPeople <= 1) {
            $errors["maxperserror"] = true;
        }

        $currentDate = new \DateTime();
        $eventDate = \DateTime::createFromFormat('Y-m-d', $eventDTO->date);

        if ($eventDate < $currentDate) {
            $errors["dateerror"] = true;
        }

        if (!array_filter($errors)) {
           return false;
        }
        return $errors;
    }
}
