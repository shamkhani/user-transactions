<?php

namespace App\Service\Transaction;

use DateTime;

interface TransactionServiceInterface
{
    public function addTransaction(int $userId, float $amount, string $tradckingId, DateTime $dateTime): int;
    public function getUserTotalTransaction(int $userId): array;
    public function getAllUserTotalTransaction(): array;
}
