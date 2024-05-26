<?php

namespace App\Core\Application\Service\Me;

use App\Core\Domain\Models\ListEvent\ListEvent;
use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ListEventRepositoryInterface;
use App\Core\Domain\Repository\PermissionRepositoryInterface;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class MeService
{
    private UserRepositoryInterface $user_repository;

    public function __construct(
        UserRepositoryInterface $user_repository,
    ) {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(UserAccount $account): MeResponse
    {
        $user = $this->user_repository->find($account->getUserId());
        if (!$user) {
            UserException::throw("user tidak ditemukan", 1006, 404);
        }
        
        return new MeResponse($user);
    }
}
