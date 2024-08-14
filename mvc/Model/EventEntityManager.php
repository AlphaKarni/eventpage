<?php

namespace Model;

class EventEntityManager
{
    public function saveEvents($events,$json_file): void
    {
        file_put_contents($json_file, json_encode($events, JSON_PRETTY_PRINT));
        header('Location: '."http://localhost:8000/index.php");
    }
}
