<?php

namespace App\Core\Application\Service\GetDetailKarya;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Repository\TagRepositoryInterface;
use App\Core\Domain\Repository\KaryaRepositoryInterface;
use App\Core\Domain\Repository\KaryaTagRepositoryInterface;
use App\Core\Application\Service\GetDetailKarya\GetDetailKaryaResponse;
use App\Core\Domain\Repository\UserRepositoryInterface;

class GetDetailKaryaService
{
    private TagRepositoryInterface $tag_repository;
    private KaryaRepositoryInterface $karya_repository;
    private KaryaTagRepositoryInterface $karya_tag_repository;
    private UserRepositoryInterface $user_repository;

    public function __construct(TagRepositoryInterface $tag_repository, KaryaRepositoryInterface $karya_repository, KaryaTagRepositoryInterface $karya_tag_repository, UserRepositoryInterface $user_repository)
    {
        $this->tag_repository = $tag_repository;
        $this->karya_repository = $karya_repository;
        $this->karya_tag_repository = $karya_tag_repository;
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $id): GetDetailKaryaResponse
    {
        $karya = $this->karya_repository->find(new KaryaId($id));

        if (!$karya) {
            throw new UserException("Karya not found", 404);
        }
        $tags = $this->karya_tag_repository->findByKaryaId($karya->getId());
        $tag_response = [];
        foreach ($tags as $tag) {
            $tag_response[] = $this->tag_repository->find($tag->getTagId())->getTag();
        }
        $user = $this->user_repository->find($karya->getUserId());
        $response = new GetDetailKaryaResponse(
            $karya->getId()->toString(),
            $karya->getTitle(),
            $karya->getCreator(),
            $karya->getDescription(),
            $karya->getImage(),
            $karya->getCount(),
            $user->getPhone(),
            $tag_response
        );

        return $response;
    }
}
