<?php declare(strict_types=1);

namespace Tests\Model;

use App\Model\UserEntityManager;
use PHPUnit\Framework\TestCase;

class UserEntityManagerTest extends TestCase
{
    private UserEntityManager $userEntityManager;
    public string $userFilePath;

    protected function setUp(): void
    {
        $this->userEntityManager = new UserEntityManager();
        $this->userFilePath = sys_get_temp_dir() . '/testusers.json';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->userFilePath)) {
            unlink($this->userFilePath);
        }
    }

    public function testSave(): void
    {
        $users =
        [
            ['username' => "test", 'email' => 'test@test.com'],
            ['username' => "test2", 'email' => 'test2@test.com']
        ];

        $this->userEntityManager->saveUsers($this->userFilePath, $users);
        $this->assertFileExists($this->userFilePath);

        $content = file_get_contents($this->userFilePath);
        $this->assertNotEmpty($content);
    }
}
