<?php

namespace App\Core\Application\Service\GetModel;

use Illuminate\Support\Facades\Http;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Repository\TagRepositoryInterface;
use App\Core\Domain\Repository\KaryaRepositoryInterface;
use App\Core\Domain\Repository\KaryaTagRepositoryInterface;
use App\Core\Application\Service\Pagination\PaginationRequest;
use App\Core\Application\Service\Pagination\PaginationResponse;
use App\Core\Application\Service\GetAllKarya\GetAllKaryaResponse;

class GetModelService
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

        $url = 'https://yotakey-artmarch-recommendation.hf.space/run/predict';

        $data = [
            'data' => [
                'search',
                $request->getSearch(),
                $request->getSearch(),
                $request->getPerPage()
            ]
        ];

        $response = Http::post($url, $data);

        if (!$response->successful()) {
            throw new UserException("search to model error", 1234, 400);
        }

        $karyas_id_str = $response->json()['data'][0];

        $karyas_id_str = str_replace(['[', ']', "'", ' '], '', $karyas_id_str);
        $karyas_id_str = trim($karyas_id_str);


        $karyas_id = explode(",", $karyas_id_str);

        $karyas_id = array_map(function ($item) {
            return trim($item, "'");
        }, $karyas_id);

        $response = [];
        foreach ($karyas_id as $karya_id) {
            $karya = $this->karya_repository->find(new KaryaId($karya_id));
            if (!$karya) {
                continue;
            }
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

        $meta_data = [
            'page' => 1,
            'max_page' => 1
        ];

        return new PaginationResponse($response, $meta_data);
    }
}
