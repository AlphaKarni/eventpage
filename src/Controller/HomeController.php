<?php

namespace App\Controller;

use App\Database\Database;
use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Core\EventValidation;
use App\Core\ViewInterface;
use App\Model\Mapper\EventMapper;
use App\Model\UserRepository;

class HomeController
{

    public function __construct(
        public EventRepository $eventRepository,
        public EventEntityManager $eventEntityManager,
        public EventValidation $eventValidation,
        public ViewInterface $view,
        public EventMapper $eventMapper,
        public Database $database,
        public UserRepository $userRepository
    ) {}

    public function loadEventSignup(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST")
        {
            $validateEvent = [
                "Name" => $_POST["Name"],
                "Date" => $_POST["Date"],
                "Description" => $_POST["Description"],
                "MaxPeople" => $_POST["MaxPeople"],
            ];

            $eventDTO = $this->eventMapper->getEventDTO($validateEvent);
            $result = $this->eventValidation->validateEvent($eventDTO);

            if ($result === false)
            {
                $events[] = $eventDTO;
                $this->eventRepository->saveEvent($eventDTO);
                header('Location: /index.php?');
            }
            else
            {
                $errors = $result;
            }
        }

        $events = $this->eventRepository->fetchAllEvents();

        if ($_SESSION["loggedIn"] === true)
        {
            if (isset($_GET["joinevent"]))
            {
                $event = $events[$_GET["joinevent"]];
                $this->eventEntityManager->joinEvent($event);
                header('Location: /index.php?details='.$event["eventID"]);
            }
            if (isset($_GET["leaveevent"]))
            {
                $event = $events[$_GET["leaveevent"]];
                $this->eventEntityManager->leaveEvent($event);
                header('Location: /index.php?details='.$event["eventID"]);
            }
        }

        if (isset($_GET["details"]))
        {
            $event = $this->eventRepository->fetchEvent($_GET["details"]);
            $this->view->addParameter('event', $event[0]);

            $participants = $this->userRepository->fetchEventParticipants($event["eventID"]);
            $this->view->addParameter('participants', $participants);
            var_dump($participants);
            $this->view->display(__DIR__ . '/../View/event.latte');
            exit;
        }

        $errors = [];
        $this->view->addParameter('errors', $errors);

        $participants = $this->userRepository->fetchAllParticipants();
        $this->view->addParameter('participants', $participants);

        $this->view->addParameter('events', $events);
        $this->view->addParameter('loggedIn', $_SESSION["loggedIn"]);
        $this->view->addParameter('username', $_SESSION["username"]);

        $this->view->display(__DIR__ . '/../View/homepage.latte');
    }
}