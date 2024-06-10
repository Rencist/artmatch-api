<?php

namespace App\Core\Application\Service\DeleteKarya;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Repository\KaryaRepositoryInterface;
use App\Core\Domain\Repository\KaryaTagRepositoryInterface;

class DeleteKaryaService
{
    private KaryaRepositoryInterface $karya_repository;
    private KaryaTagRepositoryInterface $karya_tag_repository;

    public function __construct(KaryaRepositoryInterface $karya_repository, KaryaTagRepositoryInterface $karya_tag_repository)
    {
        $this->karya_repository = $karya_repository;
        $this->karya_tag_repository = $karya_tag_repository;
    }

    public function execute(string $id)
    {
        $karya_id = new KaryaId($id);
        $karya = $this->karya_repository->find($karya_id);
        if (!$karya) {
            throw new UserException("Karya not found", 404);
        }

        $this->karya_repository->delete($karya_id);
        $this->karya_tag_repository->delete($karya_id);
    }
}
