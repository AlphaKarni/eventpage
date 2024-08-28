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
                "date" => "2203-12-12",
                "desc" => "Tests",
                "maxpers" => "2",
                "id" => 0,
                "joined_pers" => 0,
                "joined_user_usernames" => [],
            ];
        $eventValidation = new EventValidation();
        $result = $eventValidation->EventValidation($events, $validateEvent);
        if (count($result) === 4){
            print_r ("Error because of :\n");
        } else {
            $this->assertSame($validateEvent, $result[0]);
        }

        print_r($result);
        print_r(date("y-m-d"));
    }
}