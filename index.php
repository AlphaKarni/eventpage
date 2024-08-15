<?php declare(strict_types=1);

use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\LogoutController;
use App\Controller\RegistrationController;

session_start();

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . "/src/Controller/HomeController.php";
require_once __DIR__ . '/src/Controller/LoginController.php';
require_once __DIR__ . '/src/Controller/LogoutController.php';
require_once __DIR__ . '/src/Controller/RegistrationController.php';

$latte = new Latte\Engine;

$page = $_GET['page'];

switch ($page) {
    case 'login': new LoginController();
        (new LoginController)->loadLogin($latte);
        break;

    case 'register': new RegistrationController();
        (new RegistrationController)->loadRegistration($latte);
        break;
    case 'logout':
        (new LogoutController)->loadLogout();
        break;

    default: new HomeController();
        (new HomeController)->loadEventSignup($latte);
        break;
}











