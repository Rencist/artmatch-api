<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Karya\Karya;
use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\KaryaRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlKaryaRepository implements KaryaRepositoryInterface
{
    public function persist(Karya $karyas): void
    {
        DB::table('karya')->upsert([
            'id' => $karyas->getId()->toString(),
            'user_id' => $karyas->getUserId()->toString(),
            'title' => $karyas->getTitle(),
            'creator' => $karyas->getCreator(),
            'description' => $karyas->getDescription(),
            'image' => $karyas->getImage(),
            'count' => $karyas->getCount() ?? 0
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(KaryaId $id): ?Karya
    {
        $row = DB::table('karya')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $rows = DB::table('karya')->get();
        foreach ($rows as $row) {
            $karyas[] = $this->constructFromRows([$row])[0];
        }

        return $karyas;
    }

    public function delete(KaryaId $id): void
    {
        DB::table('karya')->where('id', $id->toString())->delete();
    }

    public function getAllWithPagination(int $page, int $per_page, ?string $sort, ?bool $desc, ?string $search, ?array $filter): array
    {
        $rows = DB::table('karya');

        if ($search) {
            $rows->where('title', 'like', '%' . $search . '%');
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

    public function findByUserId(UserId $user_id): array
    {
        $rows = DB::table('karya')->where('user_id', $user_id->toString())->get();
        foreach ($rows as $row) {
            $karyas[] = $this->constructFromRows([$row])[0];
        }

        return $karyas;
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $karyas = [];
        foreach ($rows as $row) {
            $karyas[] = new Karya(
                new KaryaId($row->id),
                new UserId($row->user_id),
                $row->title,
                $row->creator,
                $row->description,
                $row->image,
                $row->count
            );
        }
        return $karyas;
    }
}
