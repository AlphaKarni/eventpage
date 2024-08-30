<?php declare(strict_types=1);

namespace Tests\Controller;

use App\Controller\RegistrationController;
use PHPUnit\Framework\TestCase;

class registrationControllerTest extends TestCase
{
    protected function setUp(): void
    {
        session_start();
        parent::setUp();
        $this->testFilePath = __DIR__ . '/test_user.json';
    }
    protected function tearDown(): void
    {
        session_destroy();
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
        parent::tearDown();
    }
    public function testloadRegistration()
    {

    }
}
