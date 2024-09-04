<?php declare(strict_types=1);


use App\Controller\HomeController;
use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Core\EventValidation;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    public HomeController $homeController;
    public EventRepository $eventRepository;
    public EventEntityManager $eventEntityManagerMock;
    public EventValidation $eventValidation;

    protected function setUp(): void
    {
        session_start();
        $this->eventEntityManagerMock = $this->createMock(App\Model\EventEntityManager::class);
        $this->homeController = new App\Controller\HomeController();
    }
    protected function tearDown(): void
    {
        session_destroy();
    }

    public function testJoinEvent()
    {
        $latte = new Latte\Engine;

        $_SESSION['logged_in'] = true;
        $_GET['joinevent'] = 'event1';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $events = [['id' => 'Test', 'name' => 'Test Event']];
        $this->eventRepository->findAllEvents()->willReturn($events);
        $this->eventEntityManagerMock->expects($this->once())
            ->method('joinEvent')
            ->with($this->equalTo($events), $this->equalTo('event1'));

        $this->homeController->loadEventSignup($latte);
    }

    public function testLeaveEvent()
    {
        $latte = new Latte\Engine;

        $_SESSION['logged_in'] = true;
        $_GET['leaveevent'] = 'event1';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $events = [['id' => 'Test', 'name' => 'Test Event']];
        $this->eventRepositoryMock->
        $this->eventEntityManagerMock->expects($this->once())
            ->method('leaveEvent')
            ->with($this->equalTo($events), $this->equalTo('event1'));

        $this->homeController->loadEventSignup($latte);
    }

    public function testPostRequestMethodHandling()
    {
        $latte = new Latte\Engine;

        $_SESSION['logged_in'] = true;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => 'New Event',
            'date' => '2024-09-04',
            'desc' => 'Description',
            'maxpers' => 50,
        ];

        $events = [['id' => 'Test', 'name' => 'Test Event']];
        $this->eventRepositoryMock->method('findAllEvents')->willReturn($events);
        $this->eventValidationMock->method('validateEvent')->willReturn([]);

        $this->homeController->loadEventSignup($latte);
    }
}

?>
