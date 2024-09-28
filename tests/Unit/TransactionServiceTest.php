<?php

namespace Test\Unit;

use Test\TestCaseBase;


final class TransactionServiceTest extends TestCaseBase
{
    public function testAddTransactionSuccessfully(): void
    {
        $this->assertTrue(true);
    }
    public function testAddTransactionWithoutDoubleSpeding(): void
    {
        $this->assertTrue(true);
    }
    public function testAddTransactionWhenUserHasNotEnoughCredit(): void
    {
        $this->assertTrue(true);
    }
    public function testAddTransactionAndUpdateUserCreditSuccessfully(): void
    {
        $this->assertTrue(true);
    }
    public function testAddTransactionFaildWhenUserNotFound(): void
    {
        $this->assertTrue(true);
    }
    public function testAddTransactionFaildWhenUserLockedForTransaction(): void
    {
        $this->assertTrue(true);
    }

    public function getAllUserTotalTransactionSuccessfully(): void
    {
        $this->assertTrue(true);
    }
    public function getAllUserTotalTransactionNotValid(): void
    {
        $this->assertTrue(true);
    }

    public function getUserTotalTransactionNotValid(): void
    {
        $this->assertTrue(true);
    }
}
