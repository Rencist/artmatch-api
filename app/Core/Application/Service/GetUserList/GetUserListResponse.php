<?php

namespace App\Core\Application\Service\GetUserList;

use JsonSerializable;
use App\Core\Domain\Models\User\User;

class GetUserListResponse implements JsonSerializable
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->user->getId()->toString(),
            'email' => $this->user->getEmail()->toString(),
            'phone' => $this->user->getPhone(),
            'name' => $this->user->getName(),
            'preference' => $this->user->getPreference(),
            'role' => $this->user->getRole(),
            'artist_type' => $this->user->getArtistType()
        ];
    }
}
