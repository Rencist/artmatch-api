<?php

namespace App\Core\Application\Service\RegisterUser;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\User\User;
use App\Core\Application\Mail\AccountVerificationEmail;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;

class RegisterUserService
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param AccountVerificationRepositoryInterface $account_verification_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(RegisterUserRequest $request)
    {
        $registeredUser = $this->user_repository->findByEmail($request->getEmail());
        if ($registeredUser) {
            UserException::throw("Email already taken", 1022, 404);
        }

        $user = User::create(
            new Email($request->getEmail()),
            'user',
            $request->getPassword()
        );
        $this->user_repository->persist($user);
    }
}
