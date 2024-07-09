<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Form\Form;
use App\Core\Domain\Models\Form\FormId;
use App\Core\Domain\Models\Form\FormStatus;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\FormRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlFormRepository implements FormRepositoryInterface
{
    public function persist(Form $forms): void
    {
        DB::table('form')->upsert([
            'id' => $forms->getId()->toString(),
            'user_id_from' => $forms->getUserIdFrom()->toString(),
            'user_id_to' => $forms->getUserIdTo()->toString(),
            'title' => $forms->getTitle(),
            'bank_account' => $forms->getBankAccount(),
            'bank_type' => $forms->getBankType(),
            'status' => $forms->getStatus()->value,
            'price' => $forms->getPrice()
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(FormId $id): ?Form
    {
        $row = DB::table('form')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $rows = DB::table('form')->get();
        foreach ($rows as $row) {
            $forms[] = $this->constructFromRows([$row])[0];
        }

        return $forms;
    }

    public function delete(FormId $id): void
    {
        DB::table('form')->where('id', $id->toString())->delete();
    }

    public function findByUserFromId(UserId $user_id): array
    {
        $rows = DB::table('form')->where('user_id_from', $user_id->toString())->get();
        foreach ($rows as $row) {
            $forms[] = $this->constructFromRows([$row])[0];
        }

        return $forms;
    }

    public function findByUserToId(UserId $user_id): array
    {
        $rows = DB::table('form')->where('user_id_to', $user_id->toString())->get();
        foreach ($rows as $row) {
            $forms[] = $this->constructFromRows([$row])[0];
        }

        return $forms;
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $forms = [];
        foreach ($rows as $row) {
            $forms[] = new Form(
                new FormId($row->id),
                new UserId($row->user_id_from),
                new UserId($row->user_id_to),
                $row->title,
                $row->bank_account,
                $row->bank_type,
                FormStatus::from($row->status),
                $row->price
            );
        }
        return $forms;
    }
}
