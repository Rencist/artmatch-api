<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Chat\Chat;
use App\Core\Domain\Models\Chat\ChatId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\ChatRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlChatRepository implements ChatRepositoryInterface
{
    public function persist(Chat $chats): void
    {
        DB::table('chat')->upsert([
            'id' => $chats->getId()->toString(),
            'user_id_from' => $chats->getUserIdFrom()->toString(),
            'user_id_to' => $chats->getUserIdTo()->toString(),
            'message' => $chats->getMessage(),
            'is_watched' => $chats->getIsWatched(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function findByUserId(UserId $id): ?array
    {
        $row = DB::table('chat')->where('id', $id->toString())->orderBy('updated_at')->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $chats = [];
        foreach ($rows as $row) {
            $chats[] = new Chat(
                new ChatId($row->id),
                new UserId($row->user_id_from),
                new UserId($row->user_id_to),
                $row->message,
                $row->is_watched,
                $row->created_at
            );
        }
        return $chats;
    }
}
