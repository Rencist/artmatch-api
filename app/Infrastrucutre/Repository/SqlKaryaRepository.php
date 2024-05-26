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
                $row->image
            );
        }
        return $karyas;
    }
}
