<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\Tag\TagId;
use App\Core\Domain\Repository\TagRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlTagRepository implements TagRepositoryInterface
{
    public function persist(Tag $tag): void
    {
        DB::table('tag')->upsert([
            'id' => $tag->getId()->toString(),
            'tag' => $tag->getTag(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(TagId $id): ?Tag
    {
        $row = DB::table('tag')->where('id', $id->toString())->first();

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
        $tag = [];
        foreach ($rows as $row) {
            $tag[] = new Tag(
                new TagId($row->id),
                $row->tag
            );
        }
        return $tag;
    }
}
