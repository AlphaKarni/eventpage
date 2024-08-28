<?php
/** @noinspection ALL */

namespace App\Controller;

use App\Model\EventEntityManager;
use App\Model\EventRepository;
use App\Core\EventValidation;

use function PHPUnit\Framework\assertSame;

require_once __DIR__ . '/../Model/EventRepository.php';
require_once __DIR__ . '/../Model/EventEntityManager.php';
require_once __DIR__ . '/../Core/EventValidation.php';


class HomeController
{
    public EventRepository $eventRepository;
    public EventEntityManager $eventEntityManager;
    public EventValidation $eventValidation;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
        $this->eventEntityManager = new EventEntityManager();
        $this->eventValidation = new EventValidation();
    }

    public function loadEventSignup($latte): void
    {
        $json_file = __DIR__ . '/../../events.json';
        $events = $this->eventRepository->findAllEvents($json_file);

        if ($_SESSION["logged_in"] === true && (isset($_GET["joinevent"]))) {
            $eevent = $_GET["joinevent"];
            $this->eventEntityManager->joinEvent($events, $eevent);
        }
        if ($_SESSION["logged_in"] === true && (isset($_GET["leaveevent"]))) {
            $eevent = $_GET["leaveevent"];
            $this->eventEntityManager->leaveEvent($events, $eevent);
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $validateEvent = [
                "name" => $_POST["name"],
                "date" => $_POST["date"],
                "desc" => $_POST["desc"],
                "maxpers" => $_POST["maxpers"],
                "id" => count($events),
                "joined_pers" => 0,
                "joined_user_usernames" => [],
            ];

            $result = $this->eventValidation->validate($events, $validateEvent);
            if (count($result) === 4) {
                $errors = $result;
            } else {
                $events = $result;
                $this->eventEntityManager->saveEvents($events);
            }
        }
        $params = [
            'events' => $events,
            "errors" => $errors,
            "logged_in" => $_SESSION["logged_in"],
            "username" => $_SESSION["username"],
        ];
        $latte->render(__dir__ . '/../View/index.latte', $params);

    }
}