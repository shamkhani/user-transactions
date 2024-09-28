<?php

namespace App\Entity;

class User
{
    private int $id;
    private string $name;
    private float $credit;

    public function __construct(int $id, string $name, float $credit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->credit = $credit;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCredit(): float
    {
        return $this->credit;
    }

    public function setCredit($credit)
    {
        $this->credit = $credit;
    }
}
