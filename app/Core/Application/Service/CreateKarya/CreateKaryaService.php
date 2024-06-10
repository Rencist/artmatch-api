<?php

namespace App\Core\Application\Service\CreateKarya;

use Illuminate\Support\Facades\Http;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\Karya\Karya;
use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Models\KaryaTag\KaryaTag;
use App\Core\Domain\Models\Tag\TagId;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\TagRepositoryInterface;
use App\Core\Domain\Repository\KaryaRepositoryInterface;
use App\Core\Domain\Repository\KaryaTagRepositoryInterface;

class CreateKaryaService
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

    public function execute(CreateKaryaRequest $request, UserAccount $account)
    {
        $karya_id = KaryaId::generate();
        $karya = new Karya(
            $karya_id,
            $account->getUserId(),
            $request->getTitle(),
            $request->getCreator(),
            $request->getDescription(),
            $request->getImage()
        );
        $url = 'https://yotakey-artmarch-recommendation.hf.space/run/predict';
        $key_karya = $karya->getTitle() . ', oleh ' . $karya->getCreator() . ' , ' . $karya->getDescription() . ', Tag : ';

        foreach ($request->getTagId() as $tag_id) {
            $check_tag = $this->tag_repository->find(new TagId($tag_id));
            if (!$check_tag) {
                UserException::throw("Tag name not found", 1022, 404);
            }
            $key_karya .= $check_tag->getTag() . ' , ';
        }

        $data = [
            'data' => [
                'add',
                $karya->getId()->toString(),
                $key_karya,
                0
            ]
        ];

        $response = Http::post($url, $data);

        if (!$response->successful()) {
            throw new UserException("add to model error", 1234, 400);
        }

        $this->karya_repository->persist($karya);


        foreach ($request->getTagId() as $tag_id) {
            $karya_tag = KaryaTag::create($karya_id, new TagId($tag_id));
            $this->karya_tag_repository->persist($karya_tag);
        }
    }
}
