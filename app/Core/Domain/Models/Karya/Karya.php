<?php

namespace App\Core\Domain\Models\Karya;

use Exception;
use App\Core\Domain\Models\User\UserId;

class Karya
{
    private KaryaId $id;
    private UserId $user_id;
    private string $title;
    private string $creator;
    private string $description;
    private string $image;
    private ?int $count;


    public function __construct(KaryaId $id, UserId $user_id, string $title, string $creator, string $description, string $image, ?int $count)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->creator = $creator;
        $this->description = $description;
        $this->image = $image;
        $this->count = $count;
    }

    /**
     * @throws Exception
     */
    public static function create(UserId $user_id, string $title, string $creator, string $description, string $image, ?int $count): self
    {
        return new self(
            KaryaId::generate(),
            $user_id,
            $title,
            $creator,
            $description,
            $image,
            $count
        );
    }

    /**
     * @return KaryaId
     */
    public function getId(): KaryaId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getCreator(): string
    {
        return $this->creator;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return ?int
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    public function incrementCount(): void
    {
        $this->count += 1;
    }
}
