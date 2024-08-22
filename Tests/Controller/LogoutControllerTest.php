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

        $con = new LogoutController();
        $con->loadLogout();

        $this->assertSame([], $_SESSION);
    }
}
