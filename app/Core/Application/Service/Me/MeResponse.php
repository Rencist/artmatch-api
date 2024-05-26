<?php

namespace App\Core\Application\Service\Me;

use App\Core\Domain\Models\User\User;
use JsonSerializable;

class MeResponse implements JsonSerializable
{
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'email' => $this->user->getEmail()->toString(),
            'role' => $this->user->getRole(),
        ];
        return $response;
    }
}
