<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Core\Application\Service\GetChat\GetChatService;
use App\Core\Application\Service\CreateChat\CreateChatRequest;
use App\Core\Application\Service\CreateChat\CreateChatService;

class ChatController extends Controller
{
    public function createChat(Request $request, CreateChatService $service): JsonResponse
    {
        $request->validate([
            'user_to' => 'required|string|max:255',
            'message' => 'required|string|max:255'
        ]);


        $input = new CreateChatRequest(
            $request->input('user_to'),
            $request->input('message')
        );
        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Success create chat");
    }

    public function getMyChat(Request $request, GetChatService $service): JsonResponse
    {
        $chat = $service->executeMyChat($request->get('account'));
        return $this->successWithData($chat, "Success get my chat");
    }
}
