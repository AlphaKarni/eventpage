<?php declare(strict_types=1);

use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\LogoutController;
use App\Controller\RegistrationController;
use App\Core\View;
use App\Database\Database;
use App\Model\EventRepository;
use App\Model\EventEntityManager;
use App\Model\UserRepository;
use App\Model\UserEntityManager;
use App\Core\EventValidation;
use App\Model\Mapper\EventMapper;
use App\Model\Mapper\UserMapper;
session_start();

require_once __DIR__ . '/vendor/autoload.php';

$view = new View();
$eventFilePath = __DIR__ . '/events.json';
$userFilePath = __DIR__ . '/user.json';
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        $db = new Database();
        $userMapper = new UserMapper;
        $userRepository = new UserRepository($userMapper, $db);
        $controller = new LoginController($userRepository, $view);
        $controller->loadLogin();
        break;

    case 'register':


        $userMapper = new UserMapper();
        $db = new Database();
        $userEntityManager = new UserEntityManager($db);
        $userRepository = new UserRepository($userMapper, $db);
        $controller = new RegistrationController($userRepository, $userEntityManager, $view, $userMapper);
        $controller->loadRegistration($userFilePath);
        break;

    case 'logout':
        $controller = new LogoutController();
        $controller->loadLogout();
        break;

    default:
        $eventEntityManager = new EventEntityManager();

        $eventValidation = new EventValidation();
        $eventMapper = new EventMapper();
        $db = new Database();
        $userMapper = new UserMapper();
        $eventRepository = new EventRepository($db);
        $userRepository = new UserRepository($userMapper, $db);
        $controller = new HomeController($eventRepository, $eventEntityManager, $eventValidation, $view, $eventMapper,$db, $userRepository);
        $controller->loadEventSignup();
        break;
}