<?php

namespace App\Core\Application\Service\CreateTag;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\Tag\Tag;
use App\Exceptions\UserException;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Repository\TagRepositoryInterface;

class CreateTagService
{
    private TagRepositoryInterface $tag_repository;

    public function __construct(TagRepositoryInterface $tag_repository)
    {
        $this->tag_repository = $tag_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $tag)
    {
        $check_tag = $this->tag_repository->findByName($tag);
        if ($check_tag) {
            UserException::throw("Tag name has already created", 1022, 404);
        }

        $tag = Tag::create($tag);
        $this->tag_repository->persist($tag);
    }
}
