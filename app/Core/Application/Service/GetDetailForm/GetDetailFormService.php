<?php

namespace App\Core\Application\Service\GetDetailForm;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Form\FormId;
use App\Core\Domain\Repository\FormRepositoryInterface;
use App\Core\Application\Service\GetDetailForm\GetDetailFormResponse;
use App\Core\Domain\Models\UserAccount;
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

    public function executeOffered(UserAccount $account): array
    {
        $form = $this->form_repository->findByUserToId($account->getUserId());

        $form_resp = [];
        foreach ($form as $f) {
            $userFrom = $this->user_repository->find($f->getUserIdFrom());
            if (!$userFrom) {
                throw new UserException("User not found", 404);
            }
            $userTo = $this->user_repository->find($f->getUserIdTo());
            if (!$userTo) {
                throw new UserException("User not found", 404);
            }

            $form_resp[] = new GetDetailFormResponse(
                $f,
                $userFrom,
                $userTo
            );
        }
        
        return $form_resp;
    }

    public function executeOffering(UserAccount $account): array
    {
        $form = $this->form_repository->findByUserFromId($account->getUserId());

        $form_resp = [];
        foreach ($form as $f) {
            $userFrom = $this->user_repository->find($f->getUserIdFrom());
            if (!$userFrom) {
                throw new UserException("User not found", 404);
            }
            $userTo = $this->user_repository->find($f->getUserIdTo());
            if (!$userTo) {
                throw new UserException("User not found", 404);
            }

            $form_resp[] = new GetDetailFormResponse(
                $f,
                $userFrom,
                $userTo
            );
        }
        
        return $form_resp;
    }

    public function executeAll(): array
    {
        $form = $this->form_repository->findAll();

        $form_resp = [];
        foreach ($form as $f) {
            $userFrom = $this->user_repository->find($f->getUserIdFrom());
            if (!$userFrom) {
                throw new UserException("User not found", 404);
            }
            $userTo = $this->user_repository->find($f->getUserIdTo());
            if (!$userTo) {
                throw new UserException("User not found", 404);
            }

            $form_resp[] = new GetDetailFormResponse(
                $f,
                $userFrom,
                $userTo
            );
        }
        
        return $form_resp;
    }
}
