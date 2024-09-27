<?php

namespace App\Controller;

use App\Database\Database;
use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Core\EventValidation;
use App\Core\ViewInterface;
use App\Model\Mapper\EventMapper;

class HomeController
{

    public function __construct(
        public EventRepository $eventRepository,
        public EventEntityManager $eventEntityManager,
        public EventValidation $eventValidation,
        public ViewInterface $view,
        public EventMapper $eventMapper,
        public Database $database
    ) {}

    public function loadEventSignup(string $eventFilePath): void
    {
        $events = $this->eventRepository->fetchAllEvents();
        $errors = [];

        if ($_SESSION["loggedIn"] === true) {
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
                "Name" => $_POST["Name"],
                "Date" => $_POST["Date"],
                "Description" => $_POST["Description"],
                "MaxPeople" => $_POST["MaxPeople"],
                "CrntPeople" => 0
            ];

            $eventDTO = $this->eventMapper->getEventDTO($validateEvent);
            $result = $this->eventValidation->validateEvent($eventDTO);
            if ($result === false) {
                $events[] = $eventDTO;
                $this->eventRepository->saveEvent($eventDTO);
                header('Location: /index.php?');
            } else {
                $errors = $result;
            }
        }
        if (isset($_GET["details"]))
        {
            $event = $events[$_GET["details"]];
            $this->view->addParameter('event', $event);
            $this->view->addParameter('event_id', $_GET["details"]);
            $this->view->addParameter('loggedIn', $_SESSION["loggedIn"]);
            $this->view->display(__DIR__ . '/../View/event.latte');
        }
        $this->view->addParameter('events', $events);
        $this->view->addParameter('errors', $errors);
        $this->view->addParameter('loggedIn', $_SESSION["loggedIn"]);
        $this->view->addParameter('username', $_SESSION["username"]);

        $this->view->display(__DIR__ . '/../View/homepage.latte');
    }
}