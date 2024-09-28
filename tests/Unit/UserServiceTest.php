<?php

namespace Test\Unit;

use App\Database\DatabaseFactory;
use App\Database\Driver\Mysql;
use App\Service\User\UserService;
use Test\TestCaseBase;
use App\Database\Connection;

final class UserServiceTest extends TestCaseBase
{
    public function testGetAllUserSuccssfuly(): void
    {
        $userService = $this->getContainer()->get(UserService::class);
        $users = ($userService->getAllUsers());
        $this->assertSame(count($users), 1000);
    }
    public function testGetAllUserEmpty(): void
    {
        $userService = $this->getContainer()->get(UserService::class);
        $users = ($userService->getAllUsers());
        $this->assertSame(count($users), 0);
    }
}
