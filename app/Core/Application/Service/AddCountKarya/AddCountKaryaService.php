<?php

namespace App\Core\Application\Service\AddCountKarya;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Repository\KaryaRepositoryInterface;

class AddCountKaryaService
{
    private KaryaRepositoryInterface $karya_repository;

    public function __construct(KaryaRepositoryInterface $karya_repository)
    {
        $this->karya_repository = $karya_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $id)
    {
        $karya = $this->karya_repository->find(new KaryaId($id));
        if (!$karya) {
            throw new UserException("Karya not found", 404);
        }
        
        $karya->incrementCount();

        $this->karya_repository->persist($karya);
    }
}
