<?php

namespace App\Entity;

class UserTotalTransaction
{
    private ?int $userId;
    private float $totalAmount;
    private string $date;
    public function __construct(?int $userId, float $totalAmount, string $date)
    {
        $this->totalAmount = $totalAmount;
        $this->userId = $userId;
        $this->date = $date;
    }
    public function getDate(): string
    {
        return $this->date;
    }
    public function getUserId(): ?int
    {
        return $this->userId;
    }
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }
}
