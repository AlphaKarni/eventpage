<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controller\RegistrationController;
use App\Model\UserEntityManager;
use App\Model\UserRepository;

class RegistrationControllerTest extends TestCase
{
    public string $testFilePath;
    private $controller;

    protected function setUp(): void
    {
        session_start();
        parent::setUp();

        $this->testFilePath = '/usertest.json';


        $this->controller = new RegistrationController($this->testFilePath);
    }

    protected function tearDown(): void
    {
        session_destroy();
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
        parent::tearDown();
    }

    public function testLoadRegistrationSuccessful()
    {
        $latte = new Latte\Engine;

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'test';
        $_POST['email'] = 'test@test.com';
        $_POST['password'] = 'test123';

        $this->controller->userRepository = new UserRepository();
        $this->controller->userEntityManager = new UserEntityManager();

        $this->controller->loadRegistration($latte, $this->testFilePath);

        $contents = file_get_contents($this->testFilePath);
        $users = json_decode($contents, true);
        $this->assertNotEmpty($users);
        $this->assertEquals('test', $users[0]['username']);
        $this->assertEquals('test@test.com', $users[0]['email']);
    }
}
