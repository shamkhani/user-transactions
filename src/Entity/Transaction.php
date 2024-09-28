<?php

namespace App\Entity;

class Transaction
{
    private float $amount;
    private string $trackingId;
    private int $userId;
    private int $id;
    public function __construct(int $id, float $amount, int $userId, string $trackigId)
    {
        $this->amount = $amount;
        $this->id = $id;
        $this->userId = $userId;
        $this->trackingId = $trackigId;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getTrackingId(): string
    {
        return $this->trackingId;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}
