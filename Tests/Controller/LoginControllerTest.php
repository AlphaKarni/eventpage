<?php declare(strict_types=1);

namespace Tests\Controller;

use App\Controller\LoginController;
use PHPUnit\Framework\TestCase;

class LoginControllerTest extends TestCase
{
    public function testLoadLogin(){

        $con = new LoginController();
        $con->loadLogin($_POST);
    }
}
