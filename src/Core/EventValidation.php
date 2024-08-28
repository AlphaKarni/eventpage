<?php

namespace App\Core;

class EventValidation
{
    public function EventValidation($events, $validateEvent): array
    {
        $errors = [
            "nameerror" => false,
            "descerror" => false,
            "maxperserror" => false,
            "dateerror" => false,
        ];

        $dV = false;

        if (strlen(trim($validateEvent['name'])) < 3) {
            $errors["nameerror"] = true;
        }

        if (strlen(trim($validateEvent['desc'])) < 5) {
            $errors["descerror"] = true;
        }

        if (is_numeric($validateEvent['maxpers'])) {
            if ($validateEvent["maxpers"] <= 1) {
                $errors["maxperserror"] = true;
            }
        } else {
            $errors["maxperserror"] = true;
        }

        if ($validateEvent["maxpers"] <= 1) {
            $errors["maxperserror"] = true;
        }

        $currentDate = date("Y-m-d");


        $dateExploded =explode("-", $currentDate);
        $vDateExploded = explode ("-", $validateEvent['date']);

        if ($vDateExploded[0] > $dateExploded[0]) {
            $dV = true;
        }
        if ($vDateExploded[0] < $dateExploded[0] && !$dV) {
            $errors["dateerror"] = true;
            return $errors;
        }
        if ($vDateExploded[0] === $dateExploded[0] && !$dV) {
            if ($vDateExploded[1] > $dateExploded[1]) {
                $dV = true;
            }
            if ($vDateExploded[1] < $dateExploded[1] && !$dV) {
                $errors["dateerror"] = true;
                return $errors;
            }
            if ($vDateExploded[1] === $dateExploded[1] && !$dV) {
                if ($vDateExploded[2] >= $dateExploded[2]) {
                    $dV = true;
                }
                if (!$dV) {
                    $errors["dateerror"] = true;
                    return $errors;
                }
            }
        }

        if ($errors["nameerror"] === false && $errors["descerror"] === false && $errors["maxperserror"] === false) {
            $events[] = $validateEvent;
            return $events;
        }
        return $errors;
    }
}
