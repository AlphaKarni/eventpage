<?php

namespace Tests\Core;

use App\Core\EventValidation;
use PHPUnit\Framework\TestCase;

class EventValidationTest extends TestCase
{
    public function testEventValidation()
    {
        $events = [];
        $validateEvent=
            [
                "name" => "123",
                "date" => "2060-12-12",
                "desc" => "Testr",
                "maxpers" => "2",
                "id" => 0,
                "joined_pers" => 0,
                "joined_user_usernames" => [],
            ];
        $eventValidation = new EventValidation();
        $result = $eventValidation->validateEvent($events, $validateEvent);

        self::assertCount(7, $result[0]);

    }
    public function testEventValidationallfalse()
    {
        $events = [];
        $validateEvent=
            [
                "name" => "1",
                "date" => "1999-12-12",
                "desc" => "T",
                "maxpers" => "1",
                "id" => 0,
                "joined_pers" => 0,
                "joined_user_usernames" => [],
            ];
        $eventValidation = new EventValidation();
        $result = $eventValidation->validateEvent($events, $validateEvent);

        self::assertCount(4, $result);

        print_r($result);

    }
}