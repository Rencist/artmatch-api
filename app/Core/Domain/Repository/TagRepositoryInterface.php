<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\Tag\TagId;

interface TagRepositoryInterface
{
    public function persist(Tag $Tag): void;

    public function find(TagId $id): ?Tag;
    
    public function constructFromRows(array $rows): array;
}
