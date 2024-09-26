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
        $mail = "1";
        $users = $userRepository->findByEmail($mail, $this->userFilePath);
        $this->assertEquals($mail, $users->email);
    }
    public function testFindByEmailfailed()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findByEmail("notexistent", $this->userFilePath);
        $this->assertEmpty($users);
    }

    public function testFindByUsername()
    {
        $userRepository = new UserRepository();
        $username = "Mustafa";
        $user = $userRepository->findByUsername($username, $this->userFilePath);
        $this->assertEquals($username, $user->username);
    }
    public function testFindByUsernamefailed()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findByUsername("notexistent", $this->userFilePath);
        $this->assertEmpty($users);
    }

}