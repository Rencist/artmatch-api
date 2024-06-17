<?php

namespace App\Core\Domain\Models\User;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;

class User
{
    private UserId $id;
    private Email $email;
    private ?string $phone;
    private ?string $name;
    private ?string $preference;
    private string $role;
    private string $artist_type;
    private string $hashed_password;
    private static bool $verifier = false;

    public function __construct(UserId $id, Email $email, ?string $phone, ?string $name, ?string $preference, string $role, string $artist_type, string $hashed_password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->phone = $phone;
        $this->name = $name;
        $this->preference = $preference;
        $this->role = $role;
        $this->artist_type = $artist_type;
        $this->hashed_password = $hashed_password;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public static function isVerifier(): bool
    {
        return self::$verifier;
    }


    public function beginVerification(): self
    {
        self::$verifier = true;
        return $this;
    }

    public function checkPassword(string $password): self
    {
        self::$verifier &= Hash::check($password, $this->hashed_password);
        return $this;
    }

    public function checkRole(string $role): self
    {
        self::$verifier &= ($this->role == $role);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function verify(): void
    {
        if (!self::$verifier) {
            UserException::throw("invalid email or password", 1003, 401);
        }
    }

    /**
     * @throws Exception
     */
    public static function create(Email $email, ?string $phone, ?string $name, ?string $preference, string $role, string $artist_type, string $unhashed_password): self
    {
        return new self(
            UserId::generate(),
            $email,
            $phone,
            $name,
            $preference,
            $role,
            $artist_type,
            Hash::make($unhashed_password)
        );
    }

    /**
    * @throws Exception
    */
    public function changePassword(string $unhashed_password) : void
    {
        $this->hashed_password = Hash::make($unhashed_password);
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getArtistType(): string
    {
        return $this->artist_type;
    }

    /**
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->hashed_password;
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
}
