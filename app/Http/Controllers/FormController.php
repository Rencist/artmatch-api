<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Core\Application\Service\CreateForm\CreateFormRequest;
use App\Core\Application\Service\CreateForm\CreateFormService;
use App\Core\Application\Service\GetDetailForm\GetDetailFormService;

class FormController extends Controller
{
    public function createForm(Request $request, CreateFormService $service): JsonResponse
    {
        $request->validate([
            'user_to' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'bank_type' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);


        $input = new CreateFormRequest(
            $request->input('user_to'),
            $request->input('title'),
            $request->input('bank_account'),
            $request->input('bank_type'),
            $request->input('price')
        );
        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Success create form");
    }

    public function getDetailForm(GetDetailFormService $service, $id): JsonResponse
    {
        $form = $service->execute($id);
        return $this->successWithData($form, "Success get detail form");
    }
}
