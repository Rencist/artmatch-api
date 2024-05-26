<?php

namespace App\Core\Application\Service\GetAllKarya;

use JsonSerializable;

class GetAllKaryaResponse implements JsonSerializable
{
    private string $id;
    private string $title;
    private string $creator;
    private string $description;
    private string $image;
    private array $tag;

    public function __construct(string $id, string $title, string $creator, string $description, string $image, array $tag)
    {
        $this->id = $id;
        $this->title = $title;
        $this->creator = $creator;
        $this->description = $description;
        $this->image = $image;
        $this->tag = $tag;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'creator' => $this->creator,
            'description' => $this->description,
            'image' => $this->image,
            'tag' => $this->tag,
        ];
    }
}
