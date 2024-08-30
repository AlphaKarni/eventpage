<?php

use PHPUnit\Framework\TestCase;
use App\Controller\HomeController;
use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Core\EventValidation;

class HomeControllerTest extends TestCase
{
    private $controller;
    private $eventRepositoryMock;
    private $eventEntityManagerMock;
    private $eventValidationMock;

    protected function setUp(): void
    {
        parent::setUp();
        session_start();

        $this->eventRepositoryMock = $this->createMock(EventRepository::class);
        $this->eventEntityManagerMock = $this->createMock(EventEntityManager::class);
        $this->eventValidationMock = $this->createMock(EventValidation::class);

        $this->controller = new HomeController();
        $this->controller->eventRepository = $this->eventRepositoryMock;
        $this->controller->eventEntityManager = $this->eventEntityManagerMock;
        $this->controller->eventValidation = $this->eventValidationMock;

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = 'test';
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        session_destroy();
    }

    public function testJoinEvent()
    {
        $latte = new Latte\Engine;
        $_GET['joinevent'] = 0;
        $events = [['id' => 0, 'name' => 'Test Event', 'joined_user_usernames' => []]];

        $this->eventRepositoryMock->method('findAllEvents')->willReturn($events);
        $this->eventEntityManagerMock->method('joinEvent')->willReturnCallback(function (&$events, $eevent) {
            $events[0]['joined_user_usernames'][] = $_SESSION['username'];
        });

        $this->controller->loadEventSignup($latte);

        $this->assertContains('test', $events[0]['joined_user_usernames']);
    }

    public function testLeaveEvent()
    {
        $latte = new Latte\Engine;
        $_GET['leaveevent'] = 1;
        $events = [['id' => 1, 'name' => 'Test Event', 'joined_user_usernames' => ['test']]];

        $this->eventRepositoryMock->method('findAllEvents')->willReturn($events);
        $this->eventEntityManagerMock->method('leaveEvent')->willReturnCallback(function (&$events, $eevent) {
            if (($key = array_search($_SESSION['username'], $events[0]['joined_user_usernames'])) !== false) {
                unset($events[0]['joined_user_usernames'][$key]);
            }
        });

        $this->controller->loadEventSignup($latte);

        $this->assertNotContains('test', $events[0]['joined_user_usernames']);
    }

    public function testPostNewEventSuccessful()
    {
        $latte = new Latte\Engine;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => 'New Event',
            'date' => '2024-08-30',
            'desc' => 'Description',
            'maxpers' => 50
        ];
        $events = [];
        $this->eventRepositoryMock->method('findAllEvents')->willReturn($events);
        $this->eventValidationMock->method('validateEvent')->willReturn([$events, true]);

        $this->eventEntityManagerMock->expects($this->once())->method('saveEvents');

        ob_start();
        $this->controller->loadEventSignup($latte);
        ob_end_clean();
    }

    public function testPostNewEventUnsuccessful()
    {
        $latte = new Latte\Engine;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => '',
            'date' => 'invalid-date',
            'desc' => '',
            'maxpers' => 'not-a-number'
        ];
        $events = [];
        $errors = ['Invalid data provided'];
        $this->eventRepositoryMock->method('findAllEvents')->willReturn($events);
        $this->eventValidationMock->method('validateEvent')->willReturn([$events, $errors]);

        $this->eventEntityManagerMock->expects($this->never())->method('saveEvents');

        ob_start();
        $this->controller->loadEventSignup($latte);
        $output = ob_get_contents();
        ob_end_clean();

        $this->assertStringContainsString('Invalid data provided', $output);
    }
}
