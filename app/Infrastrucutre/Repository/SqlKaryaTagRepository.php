<?php

namespace App\Infrastrucutre\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Tag\TagId;
use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Models\KaryaTag\KaryaTag;
use App\Core\Domain\Models\KaryaTag\KaryaTagId;
use App\Core\Domain\Repository\KaryaTagRepositoryInterface;

class SqlKaryaTagRepository implements KaryaTagRepositoryInterface
{
    public function persist(KaryaTag $karya_tags): void
    {
        DB::table('karya_tag')->upsert([
            'id' => $karya_tags->getId()->toString(),
            'karya_id' => $karya_tags->getKaryaId()->toString(),
            'tag_id' => $karya_tags->getTagId()->toString(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(KaryaTagId $id): ?KaryaTag
    {
        $row = DB::table('karya_tag')->where('id', $id->toString())->first();

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
        $karya_tags = [];
        foreach ($rows as $row) {
            $karya_tags[] = new KaryaTag(
                new KaryaTagId($row->id),
                new KaryaId($row->karya_id),
                new TagId($row->tag_id)
            );
        }
        return $karya_tags;
    }
}
