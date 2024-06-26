<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Core\Application\Service\GetModel\GetModelService;
use App\Http\Controllers\Request\PaginationValidateRequest;
use App\Core\Application\Service\CreateKarya\CreateKaryaRequest;
use App\Core\Application\Service\CreateKarya\CreateKaryaService;
use App\Core\Application\Service\DeleteKarya\DeleteKaryaService;
use App\Core\Application\Service\GetAllKarya\GetAllKaryaService;
use App\Core\Application\Service\AddCountKarya\AddCountKaryaService;
use App\Core\Application\Service\GetDetailKarya\GetDetailKaryaService;

class KaryaController extends Controller
{
    public function createKarya(Request $request, CreateKaryaService $service): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            // 'creator' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'tag_id' => 'required|array',
            'tag_id.*' => 'distinct',
        ]);


        $input = new CreateKaryaRequest(
            $request->input('title'),
            // $request->input('creator'),
            $request->input('description'),
            $request->input('image'),
            $request->input('tag_id')
        );
        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Success create karya");
    }

    public function getAllKarya(Request $request, GetAllKaryaService $service): JsonResponse
    {
        $input = PaginationValidateRequest::execute(
            $request,
            "title,creator,description"
        );

        DB::beginTransaction();
        try {
            $response = $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->successWithData($response, "Success get all karya");
    }

    public function getDetailKarya(GetDetailKaryaService $service, string $id)
    {
        DB::beginTransaction();
        try {
            $response = $service->execute($id);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->successWithData($response, "Success get detail karya");
    }

    public function addCount(AddCountKaryaService $service, string $id)
    {
        DB::beginTransaction();
        try {
            $service->execute($id);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Success add count karya");
    }

    public function deleteKarya(DeleteKaryaService $service, string $id)
    {
        DB::beginTransaction();
        try {
            $service->execute($id);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Success delete karya");
    }

    public function getModel(Request $request, GetModelService $service)
    {
        $input = PaginationValidateRequest::execute(
            $request,
            "title,creator,description"
        );


        DB::beginTransaction();
        try {
            $response = $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->successWithData($response, "Success get karya model recommendation");
    }
}
