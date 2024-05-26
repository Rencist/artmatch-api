<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Seniman\Seniman;
use App\Core\Domain\Models\Seniman\SenimanId;

interface SenimanRepositoryInterface
{
    public function persist(Seniman $Seniman): void;

    public function find(SenimanId $id): ?Seniman;
    
    public function constructFromRows(array $rows): array;
}
