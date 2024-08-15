<?php

namespace App\Core;

class EventValidation
{
    public function EventValidation($events): array
    {
        $_SESSION["nerror"] = false;
        $_SESSION["derror"] = false;

        if (strlen(trim($_POST['name'])) >= 3) {
            $event_name = htmlspecialchars($_POST['name']);
        } else {
            $_SESSION["nerror"] = true;
        }

        if (strlen(trim($_POST['desc'])) >= 5) {
            $event_desc = htmlspecialchars($_POST['desc']);
        } else {
            $_SESSION["derror"] = true;
        }

            $event_date = htmlspecialchars($_POST['date']) ?? '';
            $max_pers = htmlspecialchars($_POST['maxpers']);
            $id = count($events);

            $event_data =
                [
                    'name' => $event_name,
                    'date' => $event_date,
                    'desc' => $event_desc,
                    'maxpers' => $max_pers,
                    'id' => $id,
                    'joined_pers' => 0,
                    'joined_user_email' =>
                        [

                        ]
                ];
            $events[] = $event_data;

            return $events;
    }
}
