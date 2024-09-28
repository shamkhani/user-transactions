<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use App\AppKernel;

abstract class TestCaseBase extends TestCase
{
    public function getContainer()
    {
        $kernel = new AppKernel('testing', true);
        $kernel->boot();

        return $kernel->getContainer();
    }
}
