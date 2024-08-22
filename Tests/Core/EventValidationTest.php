<?php

namespace Tests\Core;

use App\Core\EventValidation;
use PHPUnit\Framework\TestCase;

class EventValidationTest extends TestCase
{
public function testEventValidation(){
    $events = [];
    $_POST =
        [
            "name" => "Test",
            "date" =>   "10.09.2003",
            "desc" => "TestTest",
            "maxpers" => "123",
            "id" => 0,
            "joined_pers" => 0,
            "joined_user_usernames" => []
        ];
    $eventValidation = new EventValidation();
    $result = $eventValidation->EventValidation($events);
    $this -> assertSame ($result[0], $_POST);
    print_r($events);
    }
}