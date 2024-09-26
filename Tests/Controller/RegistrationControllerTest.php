<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controller\RegistrationController;
use App\Model\UserEntityManager;
use App\Model\UserRepository;
use App\Model\Mapper\UserMapper;
use App\Core\View;

class RegistrationControllerTest extends TestCase
{
    public string $testFilePath;
    private $controller;

    protected function setUp(): void
    {
        session_start();

        parent::setUp();

        $view = new View();

        $this->testFilePath = __DIR__ . '/../TestFiles/usertest.json';
        $userRepository = new UserRepository();
        $userEntityManager = new UserEntityManager();
        $userMapper = new UserMapper();

        $this->controller = new RegistrationController($userRepository, $userEntityManager, $view, $userMapper);
        $this->controller->loadRegistration($this->testFilePath);
    }

    protected function tearDown(): void
    {
        session_destroy();
        parent::tearDown();
    }

    public function testLoadRegistrationSuccessful()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'test';
        $_POST['email'] = 'test@test.com';
        $_POST['password'] = 'test123';

        $this->controller->userRepository = new UserRepository();
        $this->controller->userEntityManager = new UserEntityManager();

        $this->controller->loadRegistration($this->testFilePath);

        $contents = file_get_contents($this->testFilePath);
        $users = json_decode($contents, true);
        $this->assertNotEmpty($users);
        $this->assertEquals('test', $users[0]['username']);
        $this->assertEquals('test@test.com', $users[0]['email']);
    }

    public function testLoadRegistrationRegistered()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'test';
        $_POST['email'] = 'test@test.com';
        $_POST['password'] = 'test123';

        $user[] = [
            'username' => 'test',
            'email' => 'test@test.com',
            'password' => 'test123'
        ];
        file_put_contents($this->testFilePath, json_encode($user, JSON_PRETTY_PRINT));

        $this->controller->userRepository = new UserRepository();
        $this->controller->userEntityManager = new UserEntityManager();

        $this->controller->loadRegistration($this->testFilePath);

        $contents = file_get_contents($this->testFilePath);
        $users = json_decode($contents, true);
        $this->assertNotEmpty($users);
        $this->assertTrue($_SESSION['emailalreadyregistered']);
        $this->assertTrue($_SESSION["usernamealreadyregistered"]);
    }
}
