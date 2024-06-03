<?php

namespace App\Core\Application\Service\RegisterUser;

class RegisterUserRequest
{
    private string $email;
    private string $password;
    private string $artist_type;

    /**
     * @param string $email
     * @param string $password
     * @param string $artist_type
     */
    public function __construct(string $email, string $password, string $artist_type)
    {
        $this->email = $email;
        $this->password = $password;
        $this->artist_type = $artist_type;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getArtistType(): string
    {
        return $this->artist_type;
    }
}
