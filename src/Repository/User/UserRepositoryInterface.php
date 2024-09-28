<?php

namespace App\Repository\User;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function getAll(): array;
    public function updateCredit(int $userId, float $amount);
    public function getForUpdate(int $userId, float $amount): ?User;
}
