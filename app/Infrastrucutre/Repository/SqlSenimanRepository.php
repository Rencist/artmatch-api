<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Seniman\Seniman;
use App\Core\Domain\Models\Seniman\SenimanId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\SenimanRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlSenimanRepository implements SenimanRepositoryInterface
{
    public function persist(Seniman $senimans): void
    {
        DB::table('seniman')->upsert([
            'id' => $senimans->getId()->toString(),
            'user_id' => $senimans->getUserId()->toString(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(SenimanId $id): ?Seniman
    {
        $row = DB::table('seniman')->where('id', $id->toString())->first();

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
        $senimans = [];
        foreach ($rows as $row) {
            $senimans[] = new Seniman(
                new SenimanId($row->id),
                new UserId($row->user_id)
            );
        }
        return $senimans;
    }
}
