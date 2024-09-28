<?php

namespace App\Repository\Transaction;

use  App\Database\Connection;
use  App\Entity\UserTotalTransaction;
use DateTime;

class TransactionRepository implements TransactionRepositoryInterface
{
    private $dbConnection;
    public function __construct(Connection $dbConnection)
    {
        $this->dbConnection = $dbConnection::getConnection();
    }

    /**
     * Add new Transaction to Database
     *
     * @param  mixed $userId
     * @param  mixed $amount
     * @param  mixed $tradckingId
     * @param  mixed $dateTime
     * @return int
     */
    public function addTransaction(int $userId, float $amount, string $tradckingId, DateTime $dateTime): int
    {
        $stmt = $this->dbConnection->prepare("INSERT INTO transactions (user_id, amount, tracking_id, created_at) VALUES (?,?,?, ?)");
        $stmt->execute([$userId, $amount, $tradckingId, $dateTime->format('Y-m-d H:i:s')]);
        return $this->dbConnection->lastInsertId();
    }

    /**
     * getUserTotalTransaction
     *
     * @param  mixed $userId
     * @return array
     */
    public function getUserTotalTransaction(int $userId): array
    {
        $transactions = [];
        $stmt = $this->dbConnection->prepare("SELECT user_id, sum(amount) as total, DATE(created_at) as created_at 
         from transactions where user_id =?  GROUP BY DATE(created_at) ");
        $stmt->execute([$userId]);
        $result = $stmt->fetchAll();
        if ($result) {
            foreach ($result as $transaction) {
                $transactions[] = $this->mapToUserTotalTransactionObject($transaction);
            }
        }
        return $transactions;
    }

    /**
     * mapToUserTotalTransactionObject
     *
     * @param  mixed $transaction
     * @return UserTotalTransaction
     */
    public function mapToUserTotalTransactionObject(array $transaction): UserTotalTransaction
    {
        return new UserTotalTransaction($transaction["user_id"] ?? null,  $transaction["total"] ?? 0, $transaction["created_at"] ?? "");
    }

    /**
     * getAllUserTotalTransaction
     *
     * @return array
     */
    public function getAllUserTotalTransaction(): array
    {
        $stmt = $this->dbConnection->prepare("SELECT sum(amount) as total, DATE(created_at) as created_at 
         from transactions GROUP BY DATE(created_at) ");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
