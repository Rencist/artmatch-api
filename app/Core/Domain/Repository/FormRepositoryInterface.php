<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Form\Form;
use App\Core\Domain\Models\Form\FormId;
use App\Core\Domain\Models\User\UserId;

interface FormRepositoryInterface
{
    public function persist(Form $Form): void;

    public function find(FormId $id): ?Form;

    public function findAll(): array;

    public function delete(FormId $id): void;

    public function findByUserFromId(UserId $user_id): array;

    public function findByUserToId(UserId $user_id): array;
}
