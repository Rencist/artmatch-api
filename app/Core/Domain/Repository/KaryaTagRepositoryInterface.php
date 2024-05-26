<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\KaryaTag\KaryaTag;
use App\Core\Domain\Models\KaryaTag\KaryaTagId;

interface KaryaTagRepositoryInterface
{
    public function persist(KaryaTag $KaryaTag): void;

    public function find(KaryaTagId $id): ?KaryaTag;
    
    public function constructFromRows(array $rows): array;
}
