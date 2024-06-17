<?php

namespace App\Core\Application\Service\UpdateUser;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\User\User;
use App\Core\Application\Mail\AccountVerificationEmail;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;

class UpdateUserService
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
    public function execute(UpdateUserRequest $request, UserAccount $account)
    {
        $registeredUser = $this->user_repository->find($account->getUserId());
        $email = $registeredUser->getEmail();
        if ($request->getEmail()) {
            if ($request->getEmail() !== $email->toString()) {
                $checkDuplicateEmail = $this->user_repository->findByEmail($request->getEmail());
                if ($checkDuplicateEmail) {
                    UserException::throw("Email already taken", 1022, 404);
                } else {
                    $email = new Email($request->getEmail());
                }
            }
        }
        $user = new User(
            $registeredUser->getId(),
            $email,
            $request->getPhone() ?? $registeredUser->getPhone(),
            $request->getName() ?? $registeredUser->getName(),
            $request->getPreference() ?? $registeredUser->getPreference(),
            $registeredUser->getRole(),
            $registeredUser->getArtistType() ?? $request->getArtistType(),
            Hash::make($request->getPassword()) ?? $registeredUser->getHashedPassword()
        );
        $this->user_repository->persist($user);
    }
}
