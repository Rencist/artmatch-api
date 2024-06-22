<?php

namespace App\Core\Application\Service\GetAllKarya;

use Illuminate\Support\Facades\Http;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Repository\TagRepositoryInterface;
use App\Core\Domain\Repository\KaryaRepositoryInterface;
use App\Core\Domain\Repository\KaryaTagRepositoryInterface;
use App\Core\Application\Service\Pagination\PaginationRequest;
use App\Core\Application\Service\Pagination\PaginationResponse;
use App\Core\Application\Service\GetAllKarya\GetAllKaryaResponse;

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
    public function execute(PaginationRequest $request): PaginationResponse
    {

        $karyas = $this->karya_repository->getAllWithPagination(
            $request->getPage(),
            $request->getPerPage(),
            $request->getSort(),
            $request->getDesc(),
            $request->getSearch(),
            $request->getFilter()
        );

        $response = [];
        foreach ($karyas['data'] as $karya) {
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
                $karya->getCount(),
                $tag_response
            );
        }

        $meta_data = [
            'page' => $request->getPage(),
            'max_page' => $karyas["max_page"]
        ];

        return new PaginationResponse($response, $meta_data);
    }
}
