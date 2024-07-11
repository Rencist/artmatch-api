<?php

namespace App\Core\Application\Service\GetUserList;

use Exception;
use App\Core\Application\Service\Pagination\PaginationResponse;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Application\Service\Pagination\PaginationRequest;

class GetUserListService
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(?PaginationRequest $request)
    {
        $users = $this->user_repository->getWithPagination(
            $request->getPage(),
            $request->getPerPage(),
            $request->getSort(),
            $request->getDesc(),
            $request->getSearch(),
            $request->getFilter()
        );

        $response = [];
        foreach ($users['data'] as $user) {
            $response[] = new GetUserListResponse(
                $user
            );
        }

        $meta_data = [
            'page' => $request->getPage(),
            'max_page' => $users["max_page"]
        ];

        return new PaginationResponse($response, $meta_data);
    }
}
