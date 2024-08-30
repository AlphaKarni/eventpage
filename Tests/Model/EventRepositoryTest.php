<?php declare(strict_types=1);

namespace Tests\Model;

use App\Model\EventRepository;
use PHPUnit\Framework\TestCase;

class EventRepositoryTest extends TestCase
{
    private string $testFilePath;
    protected function setUp(): void
    {
        parent::setUp();
        $this->testFilePath = __DIR__ . '/test_events.json';
    }
    protected function tearDown(): void
    {
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
        parent::tearDown();
    }
    public function testFindAllEventsEmpty()
    {
        $events = new EventRepository($this->testFilePath);
        $result = $events->findAllEvents();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
    public function testFindAllEventsArray()
    {
        $sampleData = [
            "name" => "test",
            "date" => "2024-08-30",
            "desc" => "teste",
            "maxpers" => "13",
            "id" => 0,
            "joined_pers" => 0,
            "joined_user_usernames" => []
        ];
        file_put_contents($this->testFilePath, json_encode($sampleData));

        $events = new EventRepository($this->testFilePath);
        $result = $events->findAllEvents();
        $this->assertIsArray($result);
        $this->assertCount(7, $result);
        $this->assertEquals($sampleData[0]['name'], $result[0]['name']);
    }
}
