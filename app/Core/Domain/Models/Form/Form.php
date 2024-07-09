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
    private string $back_account;
    private FormStatus $status;
    private float $price;


    public function __construct(FormId $id, UserId $user_id_from, UserId $user_id_to, string $title, string $back_account, FormStatus $status, float $price)
    {
        $this->id = $id;
        $this->user_id_from = $user_id_from;
        $this->user_id_to = $user_id_to;
        $this->title = $title;
        $this->back_account = $back_account;
        $this->status = $status;
        $this->price = $price;
    }

    /**
     * @throws Exception
     */
    public static function create(UserId $user_id_from, UserId $user_id_to, string $title, string $back_account, FormStatus $status, float $price): self
    {
        return new self(
            FormId::generate(),
            $user_id_from,
            $user_id_to,
            $title,
            $back_account,
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
    public function getBackAccount(): string
    {
        return $this->back_account;
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
