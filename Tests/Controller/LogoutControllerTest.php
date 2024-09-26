<?php declare(strict_types=1);

namespace Tests\Controller;

use App\Controller\LogoutController;
use PHPUnit\Framework\TestCase;
class LogoutControllerTest extends TestCase
{
    public function testLoadLogout()
    {
        session_start();
        $_SESSION = [
            "logged_in" => true,
            "username" => "test",
            "email" => "test@test.com",
            "password" => "test"
        ];
        $controller = new LogoutController();
        $controller->loadLogout();
        $this->assertEmpty($_SESSION);
    }
}