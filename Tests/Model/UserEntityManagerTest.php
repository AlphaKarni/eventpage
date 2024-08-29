<?php declare(strict_types=1);

namespace Tests\Model;

use App\Model\UserEntityManager;
use PHPUnit\Framework\TestCase;

class UserEntityManagerTest extends TestCase
{
    private UserEntityManager $userEntityManager;
    private string $testJson;

    protected function setUp(): void
    {
        $this->userEntityManager = new UserEntityManager();
        $this->testJson = sys_get_temp_dir() . '/testusers.json';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testJson)) {
            unlink($this->testJson);
        }
    }

    public function testSave(): void
    {
        $users =
        [
            ['username' => "test", 'email' => 'test@test.com'],
            ['username' => "test2", 'email' => 'test2@test.com']
        ];

        $this->userEntityManager->save($users, $this->testJson);
        $this->assertFileExists($this->testJson);

        $content = file_get_contents($this->testJson);
        $this->assertNotEmpty($content);
    }
}
