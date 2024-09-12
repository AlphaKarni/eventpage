<?php

namespace App\Core;

use App\Model\DTOs\eventDTO;

class EventValidation
{
    public function validateEvent(array $events, EventDTO $validateEvent): array
    {
        $errors = [
            "nameerror" => false,
            "descerror" => false,
            "maxperserror" => false,
            "dateerror" => false,
        ];

        if (strlen(trim($validateEvent['name'])) < 3) {
            $errors["nameerror"] = true;
        }

        if (strlen(trim($validateEvent['desc'])) < 5) {
            $errors["descerror"] = true;
        }

        if (!is_numeric($validateEvent['maxpers']) || $validateEvent['maxpers'] <= 1) {
            $errors["maxperserror"] = true;
        }

        $currentDate = new \DateTime();
        $eventDate = \DateTime::createFromFormat('Y-m-d', $validateEvent['date']);

        if ($eventDate < $currentDate) {
            $errors["dateerror"] = true;
        }

        if (!array_filter($errors)) {
            $events[] = $validateEvent;
            return $events;
        }

        return $errors;
    }
}
