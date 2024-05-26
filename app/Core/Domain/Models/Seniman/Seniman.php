<?php

namespace App\Core\Domain\Models\Seniman;

use Exception;
use App\Core\Domain\Models\User\UserId;

class Seniman
{
    private SenimanId $id;
    private UserId $user_id;

    public function __construct(SenimanId $id, UserId $user_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
    }

    /**
     * @throws Exception
     */
    public static function create(UserId $user_id): self
    {
        return new self(
            SenimanId::generate(),
            $user_id,
        );
    }

    /**
     * @return SenimanId
     */
    public function getId(): SenimanId
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
}
