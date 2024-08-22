<?php

namespace Tests\Model;

use  App\Model\EventRepository;
use PHPUnit\Framework\TestCase;


class EventRepositoryTest extends TestCase
{
    public function testFindAllEvents()
    {
        $events = new EventRepository();
        $result = $events ->findAllEvents();
        $this->assertIsArray($result);
    }
}