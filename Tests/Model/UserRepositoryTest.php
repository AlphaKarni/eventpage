<?php

namespace Tests\Model;

use App\Model\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    public function testFindByEmail()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findByEmail("1");
        $this->assertIsArray($users);
        $this->assertCount(4, $users);
    }
    public function testFindByUsername()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findByUsername("Mustafa");
        $this->assertIsArray($users);
        $this->assertCount(4, $users);
    }

}