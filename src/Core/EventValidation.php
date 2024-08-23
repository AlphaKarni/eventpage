<?php

namespace App\Core;

class EventValidation
{
    public function EventValidation(
        $events,
        $validateEvent,
        $errors,
        $eventDate,
        $currentDate
    ): array {
        if (strlen(trim($validateEvent['name'])) < 3) {
            $errors["nameerror"] = true;
        }

        if (strlen(trim($validateEvent['desc'])) < 5) {
            $errors["descerror"] = true;
        }

        if ($validateEvent["maxpers"] <= 0) {
            $errors["maxperserror"] = true;
        }

        if ($currentDate > $eventDate) {
            $errors["dateerror"] = true;
        }

        if ($errors["nameerror"] === false && $errors["descerror"] === false &&
            $errors["maxperserror"] === false && $errors["dateerror"] === false) {
            $events[] = $validateEvent;
            return $events;
        }
        return $errors;
    }
}
