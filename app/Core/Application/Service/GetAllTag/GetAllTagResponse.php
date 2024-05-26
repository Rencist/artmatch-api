<?php

namespace App\Core\Application\Service\GetAllTag;

use JsonSerializable;

class GetAllTagResponse implements JsonSerializable
{
    private string $id;
    private string $tag;

    public function __construct(string $id, string $tag)
    {
        $this->id = $id;
        $this->tag = $tag;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'tag' => $this->tag,
        ];
    }
}
