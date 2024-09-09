<?php

namespace App\Core\Domain\Models\Chat;

use App\Core\Domain\Models\Chat\ChatId;
use Exception;
use App\Core\Domain\Models\User\UserId;

class Chat
{
    private ChatId $id;
    private UserId $user_id_from;
    private UserId $user_id_to;
    private string $message;
    private bool $is_watched;
    private ?string $created_at;


    public function __construct(ChatId $id, UserId $user_id_from, UserId $user_id_to, string $message, bool $is_watched, ?string $created_at = null)
    {
        $this->id = $id;
        $this->user_id_from = $user_id_from;
        $this->user_id_to = $user_id_to;
        $this->message = $message;
        $this->is_watched = $is_watched;
        $this->created_at = $created_at;
    }

    /**
     * @throws Exception
     */
    public static function create(UserId $user_id_from, UserId $user_id_to, string $message, bool $is_watched): self
    {
        return new self(
            ChatId::generate(),
            $user_id_from,
            $user_id_to,
            $message,
            $is_watched
        );
    }

    /**
     * @return ChatId
     */
    public function getId(): ChatId
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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function getIsWatched(): bool
    {
        return $this->is_watched;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
