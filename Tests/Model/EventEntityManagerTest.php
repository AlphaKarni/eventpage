<?php declare (strict_types = 1);

namespace Tests\Model;

use App\Model\EventEntityManager;
use PHPUnit\Framework\TestCase;

class EventEntityManagerTest extends TestCase
{
    private $testFilePath;
    public array $events;
    public $eevent = 0;
    protected function setUp(): void
    {
        session_start();
        parent::setUp();
        $this->testFilePath = __DIR__ . '/test_events.json';
    }
    protected function tearDown(): void
    {
        session_destroy();
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
        parent::tearDown();
    }
    public function testJoinEvent()
    {
        $this->events  = [
            [
            "name" => "test",
            "date" => "2099-12-12",
            "desc" => "testtest",
            "maxpers" => "13",
            "id" => 0,
            "joined_pers" => 0,
            "joined_user_usernames"=> []
            ]
        ];

        $_SESSION = ["username" => "test"];

        $event = new EventEntityManager($this->testFilePath);
        $result = $event -> joinEvent($this->events, $this->eevent,);
        $this->assertContains($_SESSION["username"], $result["joined_user_usernames"]);
    }
    public function testLeaveEvent()
    {
        $this->events  = [
            [
                "name" => "test",
                "date" => "2099-12-12",
                "desc" => "testtest",
                "maxpers" => "13",
                "id" => 0,
                "joined_pers" => 1,
                "joined_user_usernames"=> [
                    0 => "test"
                ]
            ]
        ];

        $_SESSION = ["username" => "test"];

        $event = new EventEntityManager($this->testFilePath);
        $result = $event -> leaveEvent($this->events, $this->eevent);
        $this->assertNotContains($_SESSION["username"], $result["joined_user_usernames"]);
    }
}
