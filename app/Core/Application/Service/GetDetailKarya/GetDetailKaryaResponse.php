<?php

namespace App\Core\Application\Service\GetDetailKarya;

use JsonSerializable;

class GetDetailKaryaResponse implements JsonSerializable
{
    private string $id;
    private string $title;
    private string $creator;
    private string $description;
    private string $image;
    private string $count;
    private string $phone_number;
    private array $tag;

    public function __construct(string $id, string $title, string $creator, string $description, string $image, string $count, string $phone_number, array $tag)
    {
        $this->id = $id;
        $this->title = $title;
        $this->creator = $creator;
        $this->description = $description;
        $this->image = $image;
        $this->count = $count;
        $this->phone_number = $phone_number;
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
            'count' => $this->count,
            'phone_number' => $this->phone_number,
            'tag' => $this->tag,
        ];
    }
}
