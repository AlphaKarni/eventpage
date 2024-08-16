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
        $json_file = __DIR__ . '/../../events.json';

        $events = $this->eventRepository->findAllEvents($json_file);

        if ($_SESSION["logged_in"] === true && (isset($_GET["joinevent"]))) {
                $eevent = $_GET["joinevent"];
                $this->eventEntityManager->joinEvent($events, $json_file,$eevent);
        }
        if ($_SESSION["logged_in"] === true && (isset($_GET["leaveevent"]))) {
            $eevent = $_GET["leaveevent"];
            $this->eventEntityManager->leaveEvent($events, $json_file,$eevent);
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $events = $this->eventValidation->EventValidation($events);
            if ($_SESSION["nerror"] === false && $_SESSION["derror"] === false) {
                $this->eventEntityManager->saveEvents($events, $json_file);
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