<?php declare(strict_types=1);


use App\Controller\HomeController;
use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Core\EventValidation;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    private $testFilePath;
    private $latte;
    private HomeController $homeController;
    public EventRepository $eventRepository;
    public EventEntityManager $eventEntityManager;
    public EventValidation $eventValidation;

    protected function setUp(): void
    {
        session_start();

        $this->eventEntityManager = new App\Model\EventEntityManager();
        $this->homeController = new App\Controller\HomeController();
        $this->eventRepository = new App\Model\EventRepository();
        $this->eventValidation = new App\Core\EventValidation();

        $this->latte= new Latte\Engine;

        $this->testFilePath = __DIR__ . "/../TestFiles/eventtest.json";
    }
    protected function tearDown(): void
    {
        session_destroy();
    }
    public function testJoinEvent()
    {
        $events[] =
            [
                "name" => "test",
                "date" => "2999-12-12",
                "desc" => "testtest",
                "maxpers" => "10",
                "id" => 0,
                "joined_pers" => 0,
                "joined_user_usernames" => []
            ];
        if (!file_exists($this->testFilePath)) {
            $this->eventEntityManager->saveEvents($events, $this->testFilePath);
        }

        $_SESSION["username"] = "test";
        $_SESSION['logged_in'] = true;
        $_GET['joinevent'] = '0';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->homeController->loadEventSignup($this->latte, $this->testFilePath);

        $file = $this->eventRepository->findAllEvents($this->testFilePath);
        $asserttest = $file[$_GET['joinevent']];
        $this->assertContains($_SESSION["username"],$asserttest["joined_user_usernames"]);
    }

    public function testLeaveEvent()
    {
        $_SESSION["username"] = "test";
        $_SESSION['logged_in'] = true;
        $_GET['leaveevent'] = '0';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->homeController->loadEventSignup($this->latte, $this->testFilePath);

        $file = $this->eventRepository->findAllEvents($this->testFilePath);
        $asserttest = $file[$_GET['joinevent']];
        $this->assertNotContains($_SESSION["username"], $asserttest["joined_user_usernames"]);
        print_r($asserttest);
    }

    public function testValidateEventSuccess()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => 'save_successful',
            'date' => '2999-12-12',
            'desc' => 'Description',
            'maxpers' => 50,
        ];
        $this->homeController->loadEventSignup($this->latte, $this->testFilePath);

        $events = $this->eventRepository->findAllEvents($this->testFilePath);
        print_r($events);
        foreach ($events as $event) {
            if ($event['name'] === $_POST['name']) {
                $eventID = $event['id'];
            }
        }
        $this->assertSame($_POST["name"],$events[$eventID]["name"]);
        $this->eventEntityManager->deleteEvent($events,$this->testFilePath,$eventID);
    }
    public function testValidateEventFail()
    {
        $_SESSION["username"] = "test";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => 'Ye',
            'date' => '2003-09-10',
            'desc' => 'Nein',
            'maxpers' => 0,
        ];
        $this->homeController->loadEventSignup($this->latte, $this->testFilePath);
        $events = $this->eventRepository->findAllEvents($this->testFilePath);
        foreach ($events as $event) {
            $eventName = $event["name"];
            $this->assertNotSame($_POST["name"],$eventName);
        }
    }
}
?>
