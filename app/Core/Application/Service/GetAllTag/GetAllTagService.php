<?php

namespace App\Core\Application\Service\GetAllTag;

use Exception;
use App\Core\Domain\Repository\TagRepositoryInterface;

class GetAllTagService
{
    private TagRepositoryInterface $tag_repository;

    /**
     * @param TagRepositoryInterface $tag_repository
     */
    public function __construct(TagRepositoryInterface $tag_repository)
    {
        $this->tag_repository = $tag_repository;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $tags = $this->tag_repository->findAll();
        $response = [];
        foreach ($tags as $tag) {
            $response[] = new GetAllTagResponse(
                $tag->getId()->toString(),
                $tag->getTag()
            );
        }

        return $response;
    }
}
