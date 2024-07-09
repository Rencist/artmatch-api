<?php

namespace App\Core\Application\Service\GetDetailForm;

use App\Core\Domain\Models\Form\Form;
use App\Core\Domain\Models\User\User;
use JsonSerializable;

class GetDetailFormResponse implements JsonSerializable
{
    private Form $form;
    private User $user_from;
    private User $form_to;

    public function __construct(Form $form, User $user_from, User $form_to)
    {
        $this->form = $form;
        $this->user_from = $user_from;
        $this->form_to = $form_to;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->form->getId()->toString(),
            'user_id_from' => $this->form->getUserIdFrom()->toString(),
            'user_id_to' => $this->form->getUserIdTo()->toString(),
            'title' => $this->form->getTitle(),
            'bank_account' => $this->form->getBankAccount(),
            'bank_type' => $this->form->getBankType(),
            'status' => $this->form->getStatus()->value,
            'price' => $this->form->getPrice(),
            'user_from' => [
                'id' => $this->user_from->getId()->toString(),
                'name' => $this->user_from->getName(),
                'email' => $this->user_from->getEmail(),
                'phone' => $this->user_from->getPhone()
            ],
            'user_to' => [
                'id' => $this->form_to->getId()->toString(),
                'name' => $this->form_to->getName(),
                'email' => $this->form_to->getEmail(),
                'phone' => $this->form_to->getPhone()
            ]
        ];
    }
}
