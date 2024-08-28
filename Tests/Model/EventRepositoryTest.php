<?php

namespace Tests\Model;

use  App\Model\EventRepository;
use PHPUnit\Framework\TestCase;


class EventRepositoryTest extends TestCase
{
    public function testFindAllEvents()
    {
        $json_file = __DIR__ . '/../../events.json';
        $events = new EventRepository();
        $result = $events ->findAllEvents($json_file);
        $this->assertIsArray($result);
    }
    public function testFindAllEventsfailed()
    {
        $json_file = __DIR__ . '/../../eventawdawdawds.json';
        $events = new EventRepository();
        $result = $events ->findAllEvents($json_file);
        $this->assertIsArray($result);
    }
}