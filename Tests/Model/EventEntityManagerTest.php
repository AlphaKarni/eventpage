<?php declare (strict_types = 1);

namespace Tests\Model;

use App\Model\EventEntityManager;
use PHPUnit\Framework\TestCase;

class EvenTest extends TestCase
{
    private $testFilePath;
    protected function setUp(): void
    {
        parent::setUp();
        $this->testFilePath = __DIR__ . '/test_events.json';
    }
    protected function tearDown(): void
    {
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
        parent::tearDown();
    }
    public function testJoinEvent()
    {

    }




}
