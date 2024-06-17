<?php

namespace App\Core\Application\Service\UpdateUser;

class UpdateUserRequest
{
    private ?string $email;
    private ?string $phone;
    private ?string $name;
    private ?string $preference;
    private ?string $password;
    private ?string $artist_type;

    public function __construct(?string $email, ?string $phone, ?string $name, ?string $preference, ?string $password, ?string $artist_type)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->name = $name;
        $this->preference = $preference;
        $this->password = $password;
        $this->artist_type = $artist_type;
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return ?string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return ?string
     */
    public function getPreference(): ?string
    {
        return $this->preference;
    }

    /**
     * @return ?string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return ?string
     */
    public function getArtistType(): ?string
    {
        return $this->artist_type;
    }
}
