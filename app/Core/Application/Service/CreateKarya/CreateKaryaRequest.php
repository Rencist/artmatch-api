<?php

namespace App\Core\Application\Service\CreateKarya;

class CreateKaryaRequest
{
    private string $title;
    // private string $creator;
    private string $description;
    private string $image;
    private array $tag_id;

    public function __construct(string $title, string $description, string $image, array $tag_id)
    {
        $this->title = $title;
        // $this->creator = $creator;
        $this->description = $description;
        $this->image = $image;
        $this->tag_id = $tag_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    // public function getCreator(): string
    // {
    //     return $this->creator;
    // }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getTagId(): array
    {
        return $this->tag_id;
    }
}
