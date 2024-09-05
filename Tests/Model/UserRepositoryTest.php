<?php declare(strict_types=1);

namespace Tests\Model;

use App\Model\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private string $userFilePath;
    public function setUp(): void
    {
        $this->userFilePath = __DIR__ . "/../../user.json";
    }

    public function testFindByEmail()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findByEmail("1", $this->userFilePath);
        $this->assertIsArray($users);
        $this->assertCount(3, $users);
    }
    public function testFindByEmailfailed()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findByEmail("notexistent", $this->userFilePath);
        $this->assertIsArray($users);
        $this->assertCount(0, $users);
    }

    public function testFindByUsername()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findByUsername("Mustafa", $this->userFilePath);
        $this->assertIsArray($users);
        $this->assertCount(3, $users);
    }
    public function testFindByUsernamefailed()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findByUsername("notexistent", $this->userFilePath);
        $this->assertIsArray($users);
        $this->assertCount(0, $users);
    }

}