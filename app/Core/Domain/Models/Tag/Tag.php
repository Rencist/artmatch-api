<?php

namespace App\Core\Domain\Models\Tag;

use Exception;

class Tag
{
    private TagId $id;
    private string $tag;

    public function __construct(TagId $id, string $tag)
    {
        $this->id = $id;
        $this->tag = $tag;
    }

    /**
     * @throws Exception
     */
    public static function create(string $tag): self
    {
        return new self(
            TagId::generate(),
            $tag,
        );
    }

    /**
     * @return TagId
     */
    public function getId(): TagId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }
}
