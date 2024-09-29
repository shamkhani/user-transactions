<?php

namespace App\Repository\User;

use  App\Database\Connection;
use  App\Entity\User;

class UserRepository implements UserRepositoryInterface
{
    private $dbConnection;
    public function __construct(Connection $dbConnection)
    {
        $this->dbConnection = $dbConnection::getConnection();;
    }

    /**
     * getAll
     *
     * @return array
     */
    public function getAll(): array
    {
        //TODO: Add Pagination 
        $users = [];
        $stmt = $this->dbConnection->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->fetchAll();
        if ($result) {
            foreach ($result as $userArary) {
                $users[] = $this->mapToUserObject($userArary);
            }
        }
        return $users;
    }

    /**
     * updateCredit
     *
     * @param  mixed $userId
     * @param  mixed $amount
     * @return void
     */
    public function updateCredit(int $userId, float $amount)
    {
        $stmt = $this->dbConnection->prepare("update users set users.credit= users.credit+(?) where id=? and credit+? >= 0  ");
        $stmt->execute([$amount, $userId, abs($amount)]);
    }

    private function mapToUserObject(array $user): User
    {
        return new User($user["id"], $user["name"], $user["credit"]);
    }

    /**
     * getForUpdate
     *
     * @param  mixed $userId
     * @param  mixed $amount
     * @return User
     */
    public function getForUpdate(int $userId, float $amount): ?User
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM users where id = ? FOR UPDATE");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        if (!$result) {
            return null;
        }
        return $this->mapToUserObject($result);
    }
}
