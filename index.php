<?php declare(strict_types=1);

use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\LogoutController;
use App\Controller\RegistrationController;
use App\Core\View;
use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Model\UserRepository;
use App\Model\UserEntityManager;
use App\Core\EventValidation;
use App\Model\Mapper\EventMapper;
use App\Model\DTOs\EventDTO;
use App\Model\Mapper\UserMapper;
use App\Model\DTOs\UserDTO;

session_start();
require_once __DIR__ . '/vendor/autoload.php';

$view = new View();
$eventFilePath = __DIR__ . '/events.json';
$userFilePath = __DIR__ . '/user.json';
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        $userRepository = new UserRepository();
        $controller = new LoginController($userRepository, $view);
        $controller->loadLogin($userFilePath);
        break;

    case 'register':
        $userRepository = new UserRepository();
        $userEntityManager = new UserEntityManager();
        $userMapper = new UserMapper();
        $controller = new RegistrationController($userRepository, $userEntityManager, $view, $userMapper);
        $controller->loadRegistration($userFilePath);
        break;

    case 'logout':
        $controller = new LogoutController($view);
        $controller->loadLogout();
        break;

    default:
        $eventRepository = new EventRepository();
        $eventEntityManager = new EventEntityManager();
        $eventValidation = new EventValidation();
        $eventMapper = new EventMapper();
        $controller = new HomeController($eventRepository, $eventEntityManager, $eventValidation, $view, $eventMapper);
        $controller->loadEventSignup($eventFilePath);
        break;
}
