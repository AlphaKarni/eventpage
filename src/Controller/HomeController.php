<?php

namespace App\Controller;

use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Core\EventValidation;
use App\Core\ViewInterface;
use App\Model\Mapper\EventMapper;
use App\Model\DTOs\EventDTO;

class HomeController
{

    public function __construct(
        public EventRepository $eventRepository,
        public EventEntityManager $eventEntityManager,
        public EventValidation $eventValidation,
        public ViewInterface $view,
        public EventMapper $eventMapper
    ) {}

    public function loadEventSignup(string $eventFilePath): void
    {
        $events = $this->eventRepository->findAllEvents($eventFilePath);
        $errors = [];
        print_r($events);
        if ($_SESSION["logged_in"] === true) {
            if (isset($_GET["joinevent"])) {
                $eventId = $_GET["joinevent"];
                $this->eventEntityManager->joinEvent($events, $eventId, $eventFilePath);
            }

            if (isset($_GET["leaveevent"])) {
                $eventId = $_GET["leaveevent"];
                $this->eventEntityManager->leaveEvent($events, $eventId, $eventFilePath);
            }
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $validateEvent = [
                "name" => $_POST["name"],
                "date" => $_POST["date"],
                "desc" => $_POST["desc"],
                "maxPers" => $_POST["maxPers"],
                "id" => count($events),
                "joinedPers" => 0,
                "joinedUserUsernames" => []
            ];

            $eventDTO = $this->eventMapper->getEventDTO($validateEvent);

            $result = $this->eventValidation->validateEvent($events, $eventDTO);
            if (count($result) !== 4) {
                $this->eventEntityManager->saveEvents($result, $eventFilePath);
                header('Location: /index.php?');

            } else {
                $errors = $result;
            }
        }

        if (isset($_GET["details"]))
        {
            $eventId = $_GET["details"];
            $event = $events[$eventId];
            $this->view->addParameter('event', $event);
            $this->view->addParameter('logged_in', $_SESSION["logged_in"]);
            $this->view->addParameter('username', $eventId);
            $this->view->display(__DIR__ . '/../View/event.latte');
            exit();
        }
        $this->view->addParameter('events', $events);
        $this->view->addParameter('errors', $errors);
        $this->view->addParameter('logged_in', $_SESSION["logged_in"]);
        $this->view->addParameter('username', $_SESSION["username"]);

        $this->view->display(__DIR__ . '/../View/homepage.latte');
    }
}