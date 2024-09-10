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

    public function findMyChat(UserId $id): array
    {
        $rows = DB::select("
        select
            aa.*,
            u.name,
            u.email
        from
            (
            select
                c.message,
                c.created_at,
                c.is_watched,
                case
                    when c.user_id_from = ? then 'ngirim'
                    else 'nerima'
                end as user_action,
                case
                    when c.user_id_from = ? then c.user_id_to
                    else c.user_id_from
                end as user_lawan
            from
                chat c
            order by
                c.created_at desc
        ) aa
        join users u on
            aa.user_lawan = u.id
        ", [$id->toString(), $id->toString()]);

        return $rows;
    }

    public function findUserChat(UserId $id, UserId $user_id): array
    {
        $rows = DB::select("
        select
            aa.*,
            u.name,
            u.email
        from
            (
            SELECT
                c.message,
                c.created_at,
                c.is_watched,
                CASE
                    WHEN c.user_id_from = ? THEN 'ngirim'
                    ELSE 'nerima'
                END AS user_action,
                CASE
                    WHEN c.user_id_from = ? THEN c.user_id_to
                    ELSE c.user_id_from
                END AS user_lawan
            FROM
                chat c
            WHERE
                (c.user_id_from = ? OR c.user_id_to = ?)
            ORDER BY
                c.created_at DESC
        ) aa
        join users u on
            aa.user_lawan = u.id
        ", [$id->toString(), $id->toString(), $user_id->toString(), $user_id->toString()]);

        return $rows;
    }

    public function updateIswatched(UserId $id, UserId $user_id): void
    {
        $user_id_login = $id->toString();
        $user_lawan_id = $user_id->toString();
        DB::table('chat')
            ->where(function ($query) use ($user_id_login) {
                $query->where('user_id_from', $user_id_login)
                    ->orWhere('user_id_to', $user_id_login);
            })
            ->where(function ($query) use ($user_lawan_id) {
                $query->where('user_id_from', $user_lawan_id)
                    ->orWhere('user_id_to', $user_lawan_id);
            })
            ->update(['is_watched' => 1]);
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
