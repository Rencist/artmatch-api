<?php

namespace App\Core\Application\Service\CreateForm;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Form\Form;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\Form\FormStatus;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\FormRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;

class CreateFormService
{
    private FormRepositoryInterface $form_repository;
    private UserRepositoryInterface $user_repository;

    public function __construct(FormRepositoryInterface $form_repository, UserRepositoryInterface $user_repository)
    {
        $this->form_repository = $form_repository;
        $this->user_repository = $user_repository;
    }

    public function execute(CreateFormRequest $request, UserAccount $account)
    {
        $user_to = $this->user_repository->find(new UserId($request->getUserTo()));
        if (!$user_to) {
            UserException::throw("User not found", 412);
        }

        $form = Form::create(
            $account->getUserId(),
            $user_to->getId(),
            $request->getTitle(),
            $request->getBankAccount(),
            $request->getBankType(),
            FormStatus::OFFERED,
            $request->getPrice()
        );

        $this->form_repository->persist($form);
    }
}
