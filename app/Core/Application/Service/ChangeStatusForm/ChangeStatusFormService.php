<?php

namespace App\Core\Application\Service\ChangeStatusForm;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Form\FormId;
use App\Core\Domain\Models\Form\FormStatus;
use App\Core\Domain\Repository\FormRepositoryInterface;

class ChangeStatusFormService
{
    private FormRepositoryInterface $form_repository;

    public function __construct(FormRepositoryInterface $form_repository)
    {
        $this->form_repository = $form_repository;
    }

    public function execute(string $id, string $status)
    {
        $form = $this->form_repository->find(new FormId($id));

        if (!$form) {
            throw new UserException("Form not found", 404);
        }

        $form->setStatus(FormStatus::from($status));

        $this->form_repository->persist($form);
    }
}
