<?php

namespace App\Core\Application\Service\CreateForm;

class CreateFormRequest
{
    private string $user_to;
    private string $title;
    private string $bank_account;
    private string $bank_type;
    private float $price;

    public function __construct(string $user_to, string $title, string $bank_account, string $bank_type, float $price)
    {
        $this->user_to = $user_to;
        $this->title = $title;
        $this->bank_account = $bank_account;
        $this->bank_type = $bank_type;
        $this->price = $price;
    }

    public function getUserTo(): string
    {
        return $this->user_to;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBankAccount(): string
    {
        return $this->bank_account;
    }

    public function getBankType(): string
    {
        return $this->bank_type;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
