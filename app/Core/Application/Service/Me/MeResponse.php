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
            'id' => $this->user->getId()->toString(),
            'email' => $this->user->getEmail()->toString(),
            'phone' => $this->user->getPhone(),
            'name' => $this->user->getName(),
            'preference' => $this->user->getPreference(),
            'role' => $this->user->getRole(),
            'artist_type' => $this->user->getArtistType()
        ];
        return $response;
    }
}
