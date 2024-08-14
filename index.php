<?php declare(strict_types=1);

use event\Controller\HomeController;
use event\Controller\LoginController;
use event\Controller\LogoutController;
use event\Controller\RegistrationController;

session_start();

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . "/mvc/Controller/HomeController.php";
require_once __DIR__ . '/mvc/Controller/LoginController.php';
require_once __DIR__ . '/mvc/Controller/LogoutController.php';
require_once __DIR__ . '/mvc/Controller/RegistrationController.php';

$latte = new Latte\Engine;

$page = $_GET['page'];

switch ($page) {
    case 'login': new LoginController();
        (new LoginController)->loadLogin($latte);
        break;

    case 'register': new RegistrationController();
        (new RegistrationController)->loadRegistration($latte);
        break;
    case 'logout': new LogoutController();
        (new LogoutController)->loadLogout();
        break;

    default: new HomeController();
        (new HomeController)->loadEventSignup($latte);
        break;
}











