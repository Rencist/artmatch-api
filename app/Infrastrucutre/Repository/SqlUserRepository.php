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
            'phone' => $users->getPhone(),
            'name' => $users->getName(),
            'preference' => $users->getPreference(),
            'role' => $users->getRole(),
            'artist_type' => $users->getArtistType(),
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

    public function getWithPagination(int $page, int $per_page, ?string $sort, ?bool $desc, ?string $search, ?array $filter): array
    {
        $rows = DB::table('users');

        if ($search) {
            $rows->where('nama', 'like', '%' . $search . '%');
        }

        if ($filter) {
            foreach ($filter as $key => $value) {
                $rows->where($key, $value);
            }
        }

        if ($sort) {
            $rows->orderBy($sort, $desc ? 'desc' : 'asc');
        }

        $rows = $rows->paginate($per_page, ['*'], 'page', $page);

        $karyas = [];
        foreach ($rows as $row) {
            $karyas[] = $this->constructFromRows([$row])[0];
        }

        return [
            "data" => $karyas,
            "max_page" => ceil($rows->total() / $per_page)
        ];
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
                $row->phone ?? null,
                $row->name ?? null,
                $row->preference ?? null,
                $row->role,
                $row->artist_type,
                $row->password
            );
        }
        return $users;
    }

    public function delete(UserId $id): void
    {
        DB::table('users')->where('id', $id->toString())->delete();
    }
}
