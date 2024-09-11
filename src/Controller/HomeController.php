<?php

namespace App\Controller;

use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Core\EventValidation;
use App\Core\ViewInterface;

class HomeController
{
    private EventRepository $eventRepository;
    private EventEntityManager $eventEntityManager;
    private EventValidation $eventValidation;
    private ViewInterface $view;

    public function __construct(
        EventRepository $eventRepository,
        EventEntityManager $eventEntityManager,
        EventValidation $eventValidation,
        ViewInterface $view
    ) {
        $this->eventRepository = $eventRepository;
        $this->eventEntityManager = $eventEntityManager;
        $this->eventValidation = $eventValidation;
        $this->view = $view;
    }

    public function loadEventSignup(string $eventFilePath): void
    {
        $events = $this->eventRepository->findAllEvents($eventFilePath);
        $errors = [];

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
                "maxpers" => $_POST["maxpers"],
                "id" => count($events),
                "joined_pers" => 0,
                "joined_user_usernames" => []
            ];

            $result = $this->eventValidation->validateEvent($events, $validateEvent);
            if (count($result) !== 4) {
                $this->eventEntityManager->saveEvents($result, $eventFilePath);
            } else {
                $errors = $result;
            }
        }

        $this->view->addParameter('events', $events);
        $this->view->addParameter('errors', $errors);
        $this->view->addParameter('logged_in', $_SESSION["logged_in"]);
        $this->view->addParameter('username', $_SESSION["username"]);

        $this->view->display(__DIR__ . '/../View/index.latte');
    }
}
