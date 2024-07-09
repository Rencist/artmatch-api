<?php

namespace App\Core\Domain\Models\Form;

enum FormStatus: string
{
    case OFFERED = 'offered';
    case PAID = 'paid';
    case FINISHED = 'finished';
    case DONE = 'done';
}
