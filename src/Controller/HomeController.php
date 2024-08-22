<?php

namespace App\Controller;

use App\Model\EventEntityManager;
use App\Model\EventRepository;
use App\Core\EventValidation;

require_once __DIR__ . '/../Model/EventRepository.php';
require_once __DIR__ . '/../Model/EventEntityManager.php';
require_once __DIR__ . '/../Core/EventValidation.php';


class HomeController
{
    public EventRepository $eventRepository;
    public EventEntityManager $eventEntityManager;
    public EventValidation $eventValidation;
    public function __construct() {
        $this->eventRepository = new EventRepository();
        $this->eventEntityManager = new EventEntityManager();
        $this->eventValidation = new EventValidation();
    }
    public function loadEventSignup($latte): void
    {
        $events = $this->eventRepository->findAllEvents();

        if ($_SESSION["logged_in"] === true && (isset($_GET["joinevent"]))) {
                $eevent = $_GET["joinevent"];
                $this->eventEntityManager->joinEvent($events,$eevent);
        }
        if ($_SESSION["logged_in"] === true && (isset($_GET["leaveevent"]))) {
            $eevent = $_GET["leaveevent"];
            $this->eventEntityManager->leaveEvent($events,$eevent);
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $events = $this->eventValidation->EventValidation($events);
            if ($_SESSION["nerror"] === false && $_SESSION["derror"] === false) {
                $this->eventEntityManager->saveEvents($events);
            }
        }
        $params = [
            'events' => $events,
            "logged_in" => $_SESSION["logged_in"],
            "username" => $_SESSION["username"],
        ];
        $latte->render(__dir__. '/../View/index.latte', $params);
    }
}