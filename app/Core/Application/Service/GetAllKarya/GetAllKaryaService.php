<?php

namespace App\Core\Application\Service\GetAllKarya;

use App\Core\Domain\Repository\KaryaRepositoryInterface;
use App\Core\Domain\Repository\KaryaTagRepositoryInterface;
use Exception;
use App\Core\Domain\Repository\TagRepositoryInterface;

class GetAllKaryaService
{
    private TagRepositoryInterface $tag_repository;
    private KaryaRepositoryInterface $karya_repository;
    private KaryaTagRepositoryInterface $karya_tag_repository;

    public function __construct(TagRepositoryInterface $tag_repository, KaryaRepositoryInterface $karya_repository, KaryaTagRepositoryInterface $karya_tag_repository)
    {
        $this->tag_repository = $tag_repository;
        $this->karya_repository = $karya_repository;
        $this->karya_tag_repository = $karya_tag_repository;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $karyas = $this->karya_repository->findAll();
        $response = [];
        foreach ($karyas as $karya) {
            $tags = $this->karya_tag_repository->findByKaryaId($karya->getId());
            $tag_response = [];
            foreach ($tags as $tag) {
                $tag_response[] = $this->tag_repository->find($tag->getTagId())->getTag();
            }
            $response[] = new GetAllKaryaResponse(
                $karya->getId()->toString(),
                $karya->getTitle(),
                $karya->getCreator(),
                $karya->getDescription(),
                $karya->getImage(),
                $tag_response
            );
        }

        return $response;
    }
}
