<?php

namespace App\Core\Application\Service\LoginUser;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Service\JwtManagerInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Service\GetIPInterface;

class LoginUserService
{
    private UserRepositoryInterface $user_repository;
    private JwtManagerInterface $jwt_factory;
    private GetIPInterface $get_ip;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param JwtManagerInterface $jwt_factory
     * @param GetIPInterface $get_ip
     */
    public function __construct(UserRepositoryInterface $user_repository, JwtManagerInterface $jwt_factory, GetIPInterface $get_ip)
    {
        $this->user_repository = $user_repository;
        $this->jwt_factory = $jwt_factory;
        $this->get_ip = $get_ip;
    }

    /**
     * @throws Exception
     */
    public function execute(LoginUserRequest $request): LoginUserResponse
    {
        $user = $this->user_repository->findByEmail($request->getEmail());
        if (!$user) {
            UserException::throw("User Tidak Ditemukan", 1006, 404);
        }
        $user->beginVerification()
            ->checkPassword($request->getPassword())
            ->verify();

        $ip = $this->get_ip->getIP();
        $token_jwt = $this->jwt_factory->createFromUser($user, $ip);
        return new LoginUserResponse($token_jwt);
    }
}
