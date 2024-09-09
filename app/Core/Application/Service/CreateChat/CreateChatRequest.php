<?php

namespace App\Core\Application\Service\CreateChat;

class CreateChatRequest
{
    private string $user_to;
    private string $message;

    public function __construct(string $user_to, string $message)
    {
        $this->user_to = $user_to;
        $this->message = $message;
    }

    public function getUserTo(): string
    {
        return $this->user_to;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
