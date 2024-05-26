<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Karya\Karya;
use App\Core\Domain\Models\Karya\KaryaId;

interface KaryaRepositoryInterface
{
    public function persist(Karya $Karya): void;

    public function find(KaryaId $id): ?Karya;

    public function findAll(): array;
    
    public function constructFromRows(array $rows): array;
}
