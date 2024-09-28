<?php

namespace App\Repository\Transaction;

use DateTime;
use  App\Entity\UserTotalTransaction;

interface TransactionRepositoryInterface
{
    public function addTransaction(int $userId, float $amount, string $tradckingId, DateTime $dateTime): int;
    public function getUserTotalTransaction(int $userId): array;
    public function getAllUserTotalTransaction(): array;
    public function mapToUserTotalTransactionObject(array $transaction): UserTotalTransaction;
}
