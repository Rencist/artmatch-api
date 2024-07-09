<?php

namespace App\Core\Application\Service\GetDetailForm;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Form\FormId;
use App\Core\Domain\Repository\TagRepositoryInterface;
use App\Core\Domain\Repository\FormRepositoryInterface;
use App\Core\Domain\Repository\FormTagRepositoryInterface;
use App\Core\Application\Service\GetDetailForm\GetDetailFormResponse;
use App\Core\Domain\Repository\UserRepositoryInterface;

class GetDetailFormService
{
    private FormRepositoryInterface $form_repository;
    private UserRepositoryInterface $user_repository;

    public function __construct(FormRepositoryInterface $form_repository, UserRepositoryInterface $user_repository)
    {
        $this->form_repository = $form_repository;
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $id): GetDetailFormResponse
    {
        $form = $this->form_repository->find(new FormId($id));

        if (!$form) {
            throw new UserException("Form not found", 404);
        }
        $userFrom = $this->user_repository->find($form->getUserIdFrom());
        if (!$userFrom) {
            throw new UserException("User not found", 404);
        }
        $userTo = $this->user_repository->find($form->getUserIdTo());
        if (!$userTo) {
            throw new UserException("User not found", 404);
        }

        $response = new GetDetailFormResponse(
            $form,
            $userFrom,
            $userTo
        );

        return $response;
    }
}
