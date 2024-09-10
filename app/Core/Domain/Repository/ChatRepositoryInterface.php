<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Chat\Chat;
use App\Core\Domain\Models\User\UserId;

interface ChatRepositoryInterface
{
    public function persist(Chat $Chat): void;

    public function findByUserId(UserId $id): ?array;

    public function findMyChat(UserId $id): array;
}
