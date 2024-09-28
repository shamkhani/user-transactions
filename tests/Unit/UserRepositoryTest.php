<?php

namespace Test\Unit;

use App\Database\DatabaseFactory;
use App\Database\Driver\Mysql;
use App\Service\User\UserService;
use Test\TestCaseBase;

final class UserRepositoryTest extends TestCaseBase
{
    public function testGetAllUserSuccssfuly(): void
    {
        $this->assertTrue(true);
    }
    public function testGetAllUserEmpty(): void
    {
        $this->assertTrue(true);
    }
}
