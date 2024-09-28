<?php

namespace App\Service\Transaction;

use App\Repository\Transaction\TransactionRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;
use App\Service\Cache\CacheServiceInterface;
use App\Service\Transaction\TransactionServiceInterface;
use DateTime;
use Exception;
use  App\Database\Connection;

class TransactionService implements TransactionServiceInterface
{

    private TransactionRepositoryInterface $transactionRepositoy;
    private UserRepositoryInterface $userRepository;
    private  $dbConnection;
    private CacheServiceInterface $cache;

    private const ALL_USER_TOTAL_AMOUNT = "ALL-USER-TOTAL-AMOUNT-PER-DAY";
    public function __construct(
        TransactionRepositoryInterface $transactionRepositoy,
        UserRepositoryInterface $userRepository,
        Connection $dbConnection,
        CacheServiceInterface $cache
    ) {
        $this->transactionRepositoy = $transactionRepositoy;
        $this->userRepository = $userRepository;
        $this->dbConnection = $dbConnection::getConnection();
        $this->cache = $cache;
    }

    /**
     *  Add Transaction for User with specific date and amount
     *
     * @param  mixed $userId
     * @param  mixed $amount
     * @param  mixed $tradckingId
     * @param  mixed $datetime
     * @return int
     */
    public function addTransaction(int $userId, float $amount, string $tradckingId, DateTime $datetime): int
    {
        $this->validateInput($userId, $amount, $tradckingId);

        $this->dbConnection->beginTransaction();
        $user = $this->userRepository->getForUpdate($userId, $amount);
        if (!$user) {
            throw new Exception("User Not Found ");
        }
        if ($user->getCredit() + $amount < 0) {
            throw new Exception("User Dose not have enough credit");
        }
        $transationId = $this->transactionRepositoy->addTransaction($userId, $amount, $tradckingId, $datetime);
        $this->userRepository->updateCredit($userId, $amount);
        $this->dbConnection->commit();
        $this->deleteAllUserTotalTransactionCache();
        return $transationId;
    }

    /**
     * getUserTotalTransaction
     *
     * @param  mixed $userId
     * @return array
     */
    public function getUserTotalTransaction(int $userId): array
    {
        return $this->transactionRepositoy->getUserTotalTransaction($userId);
    }

    /**
     * getAllUserTotalTransaction
     *
     * @return array
     */
    public function getAllUserTotalTransaction(): array
    {
        $totalTransactions = $this->cache->get(self::ALL_USER_TOTAL_AMOUNT);
        if ($totalTransactions) {
            $totalTransactions = json_decode($totalTransactions, true);
        } else {
            $totalTransactions =  $this->transactionRepositoy->getAllUserTotalTransaction();
            $this->cache->set(self::ALL_USER_TOTAL_AMOUNT, $totalTransactions ? json_encode($totalTransactions) : "");
        }

        return $this->decoreateTotalTransactionList($totalTransactions);
    }

    /**
     * Delete Cache for total amount all user transaction 
     *
     * @return void
     */
    private function deleteAllUserTotalTransactionCache(): void
    {
        $this->cache->del(self::ALL_USER_TOTAL_AMOUNT);
    }

    private function validateInput(int $userId, float $amount, string $tradckingId)
    {
        if (!$userId) {
            throw new \Exception("User Id required");
        }

        if (!$amount) {
            throw new \Exception("Amount required");
        }


        if (!$tradckingId) {
            throw new \Exception("tradckingId required");
        }

        // add more checking ...
    }

    private function decoreateTotalTransactionList(array $totalTransactions)
    {
        $transactions = [];
        foreach ($totalTransactions as $totalTransaction) {

            $transactions[] = $this->transactionRepositoy->mapToUserTotalTransactionObject($totalTransaction);
        }
        return $transactions;
    }
}
