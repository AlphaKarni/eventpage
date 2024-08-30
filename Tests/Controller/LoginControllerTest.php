<?php

use PHPUnit\Framework\TestCase;
use App\Controller\LoginController;
use App\Model\UserRepository;

$latte = new Latte\Engine;
class LoginControllerTest extends TestCase
{
    private $controller;
    private $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->controller = new LoginController();
        $this->controller->userRepository = $this->userRepositoryMock;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($_SERVER['REQUEST_METHOD'], $_POST['email'], $_POST['password']);
    }

    public function testSuccessfulLogin()
    {
        $latte = new Latte\Engine;

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'correctpassword';

        $hashedPassword = password_hash('correctpassword', PASSWORD_DEFAULT);
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => $hashedPassword
        ];

        $this->userRepositoryMock->method('findByEmail')->willReturn($userData);

        $this->controller->loadLogin($latte);

        $this->assertTrue($_SESSION["logged_in"]);
        $this->assertEquals('testuser', $_SESSION['username']);
        $this->assertEquals('test@example.com', $_SESSION['email']);
    }

    public function testIncorrectPassword()
    {
        $latte = new Latte\Engine;

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'wrongpassword';

        $hashedPassword = password_hash('correctpassword', PASSWORD_DEFAULT);
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => $hashedPassword
        ];

        $this->userRepositoryMock->method('findByEmail')->willReturn($userData);

        $this->controller->loadLogin($latte);


        $this->assertFalse($_SESSION["logged_in"]);
    }

    public function testEmailNotFound()
    {
        $latte  = new Latte\Engine;

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'unknown@example.com';
        $_POST['password'] = 'anyPassword';

        $this->userRepositoryMock->method('findByEmail')->willReturn([]);

        $this->controller->loadLogin($latte);

        $this->assertFalse($_SESSION['logged_in']);
    }
}
