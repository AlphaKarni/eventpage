<?php

use PHPUnit\Framework\TestCase;
use App\Controller\LoginController;
use App\Model\UserRepository;
use App\Core\ViewInterface;

class LoginControllerTest extends TestCase
{
    private $controller;
    private string $userFilePath;
    public ViewInterface $view;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->view = $this->createMock(ViewInterface::class);
        $this->controller = new LoginController($this->userRepositoryMock, $this->view);
        $this->controller->userRepository = $this->userRepositoryMock;
        $this->userFilePath = __DIR__ . "/../TestFiles/usertest.json";
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($_SERVER, $_POST);
    }

    public function testSuccessfulLogin()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'test@test.com';
        $_POST['password'] = 'correctpassword';

        $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $userData = [
            'username' => 'test',
            'email' => 'test@test.com',
            'password' => $hashedPassword
        ];

        $this->userRepositoryMock->method('emailExists')->willReturn($userData);

        $this->controller->loadLogin($this->userFilePath);

        $this->assertTrue($_SESSION["logged_in"]);
        $this->assertEquals('testuser', $_SESSION['username']);
        $this->assertEquals('test@test.com', $_SESSION['email']);
    }

    public function testIncorrectPassword()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'test@test.com';
        $_POST['password'] = 'wrongpassword';

        $hashedPassword = password_hash('correctpassword', PASSWORD_DEFAULT);
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => $hashedPassword
        ];

        $this->userRepositoryMock->method('emailExists')->willReturn($userData);

        $this->controller->loadLogin($this->userFilePath);


        $this->assertFalse($_SESSION["logged_in"]);
    }

    public function testEmailNotFound()
    {

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'unknown@example.com';
        $_POST['password'] = 'anyPassword';

        $this->userRepositoryMock->method('emailExists')->willReturn([]);

        $this->controller->loadLogin($this->userFilePath);

        $this->assertFalse($_SESSION['logged_in']);
    }
}
