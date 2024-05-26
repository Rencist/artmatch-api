<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Core\Application\Service\CreateKarya\CreateKaryaRequest;
use App\Core\Application\Service\CreateKarya\CreateKaryaService;
use App\Core\Application\Service\GetAllKarya\GetAllKaryaService;

class KaryaController extends Controller
{
    public function createKarya(Request $request, CreateKaryaService $service): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'creator' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'tag_id' => 'required|array',
            'tag_id.*' => 'distinct',
        ]);

        $input = new CreateKaryaRequest(
            $request->input('title'),
            $request->input('creator'),
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

    public function getAllKarya(GetAllKaryaService $service): JsonResponse
    {
        DB::beginTransaction();
        try {
            $response = $service->execute();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        
        return $this->successWithData($response, "Success get all tag");
    }
}
