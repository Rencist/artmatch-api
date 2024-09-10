<?php

namespace App\Core\Application\Service\CreateChat;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Chat\Chat;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\ChatRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;

class CreateChatService
{
    private ChatRepositoryInterface $chat_repository;
    private UserRepositoryInterface $user_repository;

    public function __construct(ChatRepositoryInterface $chat_repository, UserRepositoryInterface $user_repository)
    {
        $this->chat_repository = $chat_repository;
        $this->user_repository = $user_repository;
    }

    public function execute(CreateChatRequest $request, UserAccount $account)
    {
        $user_to = $this->user_repository->find(new UserId($request->getUserTo()));
        if (!$user_to) {
            UserException::throw("User not found", 412);
        }

        $chat = Chat::create(
            $account->getUserId(),
            new UserId($request->getUserTo()),
            $request->getMessage(),
            false
        );

        $this->chat_repository->persist($chat);
    }
}
