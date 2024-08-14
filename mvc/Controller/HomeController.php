<?php

namespace event\Controller;

use Model\EventEntityManager;
use Model\EventRepository;

require_once __DIR__ . '/../Model/EventRepository.php';
require_once __DIR__ . '/../Model/EventEntityManager.php';
class HomeController
{
    public EventRepository $eventRepository;
    public EventEntityManager $eventEntityManager;
    public function __construct() {
        $this->eventRepository = new EventRepository();
        $this->eventEntityManager = new EventEntityManager();
    }
    public function loadEventSignup($latte): void
    {
        $json_file = __DIR__ . '/../../events.json';

        $events = $this->eventRepository->findAllEvents($json_file);

        if ($_SESSION["logged_in"] === true) {
            if (isset($_GET["joinevent"])) {
                $events[$_GET["joinevent"]]["joined_pers"]++;
                $this->eventEntityManager->saveEvents($events, $json_file);
            }
        } else {
            echo "<p style ='color:red'>Login if you want to join events</p>";
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $error = false;

            $events = $this->eventRepository->findAllEvents($json_file);

            if (strlen(trim($_POST['name'])) >= 3) {
                $event_name = htmlspecialchars($_POST['name']);
            } else {
                echo "<p style ='color:red'>Event name is too short, minimum is 3 characters</p>";
                $error = true;
            }

            if (strlen(trim($_POST['desc'])) >= 5) {
                $event_desc = htmlspecialchars($_POST['desc']);
            } else {
                echo "<p style ='color:red'>Event description is too short, minimum is 5 characters</p>";
                $error = true;
            }

            $event_date = htmlspecialchars($_POST['date']) ?? '';
            $max_pers = htmlspecialchars($_POST['maxpers']);
            $id = count($events);

            if ($error === false)
            {
                $event_data =
                    [
                        'name' => $event_name,
                        'date' => $event_date,
                        'desc' => $event_desc,
                        'maxpers' => $max_pers,
                        'id' => $id,
                        'joined_pers' => 0,
                    ];
                $events[] = $event_data;
                $this->eventEntityManager->saveEvents($events,$json_file);
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