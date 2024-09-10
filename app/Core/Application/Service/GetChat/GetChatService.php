<?php

namespace App\Core\Application\Service\GetChat;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\ChatRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;

class GetChatService
{
    private ChatRepositoryInterface $chat_repository;
    private UserRepositoryInterface $user_repository;

    public function __construct(ChatRepositoryInterface $chat_repository, UserRepositoryInterface $user_repository)
    {
        $this->chat_repository = $chat_repository;
        $this->user_repository = $user_repository;
    }

    public function executeMyChat(UserAccount $account): array
    {
        $chat = $this->chat_repository->findMyChat($account->getUserId());

        $collection = collect($chat);

        $grouped = $collection->groupBy('user_lawan')->map(function ($group) {
            return $group->map(function ($item) {
                return [
                    'user_id' => $item->user_lawan,
                    'user_name' => $item->name,
                    'user_email' => $item->email,
                    'message' => $item->message,
                    'action' => $item->user_action,
                    'is_watched' => $item->is_watched,
                    'created_at' => $item->created_at,
                ];
            })->sortBy('created_at')->values();
        });

        $response = $grouped->sortByDesc(function ($items) {
            return $items->first()['created_at'];
        })->toArray();

        return $response;
    }
}
