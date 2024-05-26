<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Core\Application\Service\CreateTag\CreateTagService;
use App\Core\Application\Service\GetAllTag\GetAllTagService;

class TagController extends Controller
{
    public function createTag(Request $request, CreateTagService $service): JsonResponse
    {
        $request->validate([
            'tag' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $service->execute($request->input('tag'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Success create tag");
    }

    public function getAllTag(GetAllTagService $service): JsonResponse
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
