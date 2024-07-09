<?php

namespace App\Core\Domain\Models\Form;

use Exception;
use App\Core\Domain\Models\User\UserId;

class Form
{
    private FormId $id;
    private UserId $user_id_from;
    private UserId $user_id_to;
    private string $title;
    private string $bank_account;
    private string $bank_type;
    private FormStatus $status;
    private float $price;


    public function __construct(FormId $id, UserId $user_id_from, UserId $user_id_to, string $title, string $bank_account, string $bank_type, FormStatus $status, float $price)
    {
        $this->id = $id;
        $this->user_id_from = $user_id_from;
        $this->user_id_to = $user_id_to;
        $this->title = $title;
        $this->bank_account = $bank_account;
        $this->bank_type = $bank_type;
        $this->status = $status;
        $this->price = $price;
    }

    /**
     * @throws Exception
     */
    public static function create(UserId $user_id_from, UserId $user_id_to, string $title, string $bank_account, string $bank_type, FormStatus $status, float $price): self
    {
        return new self(
            FormId::generate(),
            $user_id_from,
            $user_id_to,
            $title,
            $bank_account,
            $bank_type,
            $status,
            $price
        );
    }

    /**
     * @return FormId
     */
    public function getId(): FormId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserIdFrom(): UserId
    {
        return $this->user_id_from;
    }

    /**
     * @return UserId
     */
    public function getUserIdTo(): UserId
    {
        return $this->user_id_to;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBankAccount(): string
    {
        return $this->bank_account;
    }

    /**
     * @return string
     */
    public function getBankType(): string
    {
        return $this->bank_type;
    }

    /**
     * @return FormStatus
     */
    public function getStatus(): FormStatus
    {
        return $this->status;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
