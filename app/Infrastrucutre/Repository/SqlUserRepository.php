<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlUserRepository implements UserRepositoryInterface
{
    public function persist(User $users): void
    {
        DB::table('users')->upsert([
            'id' => $users->getId()->toString(),
            'email' => $users->getEmail()->toString(),
            'role' => $users->getRole(),
            'password' => $users->getHashedPassword()
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(UserId $id): ?User
    {
        $row = DB::table('users')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function findByEmail(string $email): ?User
    {
        $row = DB::table('users')->where('email', $email)->first();

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
        $users = [];
        foreach ($rows as $row) {
            $users[] = new User(
                new UserId($row->id),
                new Email($row->email),
                $row->role,
                $row->password
            );
        }
        return $users;
    }

    public function getWithPagination(int $page, int $per_page): array
    {
        $rows = DB::table('users')
            ->paginate($per_page, ['*'], 'user_page', $page);
        $users = [];

        foreach ($rows as $row) {
            $users[] = $this->constructFromRows([$row])[0];
        }
        return [
            "data" => $users,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function delete(UserId $id): void
    {
        DB::table('users')->where('id', $id->toString())->delete();
    }
}
