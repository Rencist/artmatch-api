<?php

namespace App\Core\Domain\Models\KaryaTag;

use App\Core\Domain\Models\Karya\KaryaId;
use App\Core\Domain\Models\Tag\TagId;
use Exception;

class KaryaTag
{
    private KaryaTagId $id;
    private KaryaId $karya_id;
    private TagId $tag_id;

    public function __construct(KaryaTagId $id, KaryaId $karya_id, TagId $tag_id)
    {
        $this->id = $id;
        $this->karya_id = $karya_id;
        $this->tag_id = $tag_id;
    }

    /**
     * @throws Exception
     */
    public static function create(KaryaId $karya_id, TagId $tag_id): self
    {
        return new self(
            KaryaTagId::generate(),
            $karya_id,
            $tag_id,
        );
    }

    /**
     * @return KaryaTagId
     */
    public function getId(): KaryaTagId
    {
        return $this->id;
    }

    /**
     * @return KaryaId
     */
    public function getKaryaId(): KaryaId
    {
        return $this->karya_id;
    }

    /**
     * @return TagId
     */
    public function getTagId(): TagId
    {
        return $this->tag_id;
    }
}
