<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Core\Domain\Models\Email;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\Me\MeService;
use App\Core\Application\Service\LoginUser\LoginUserRequest;
use App\Core\Application\Service\LoginUser\LoginUserService;
use App\Core\Application\Service\DeleteUser\DeleteUserRequest;
use App\Core\Application\Service\DeleteUser\DeleteUserService;
use App\Core\Application\Service\UpdateUser\UpdateUserRequest;
use App\Core\Application\Service\UpdateUser\UpdateUserService;
use App\Core\Application\Service\GetUserList\GetUserListRequest;
use App\Core\Application\Service\GetUserList\GetUserListService;
use App\Core\Application\Service\RegisterUser\RegisterUserRequest;
use App\Core\Application\Service\RegisterUser\RegisterUserService;
use App\Core\Application\Service\ChangePassword\ChangePasswordRequest;
use App\Core\Application\Service\ChangePassword\ChangePasswordService;
use App\Core\Application\Service\ForgotPassword\ForgotPasswordRequest;
use App\Core\Application\Service\ForgotPassword\ForgotPasswordService;
use App\Core\Application\Service\ForgotPassword\ChangePasswordRequest as ChangeForgotPasswordRequest;

class UserController extends Controller
{
    public function createUser(Request $request, RegisterUserService $service): JsonResponse
    {
        $request->validate([
            'email' => 'email|email',
            'phone' => 'string|max:16',
            'name' => 'string|max:128',
            'preference' => 'string|max:128',
            'password' => 'min:8|max:64|string',
            'artist_type' => 'string|max:64|in:commercial,personal',
        ]);

        $input = new RegisterUserRequest(
            $request->input('email'),
            $request->input('phone'),
            $request->input('name'),
            $request->input('preference'),
            $request->input('password'),
            $request->input('artist_type')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Registrasi");
    }

    public function updateUser(Request $request, UpdateUserService $service): JsonResponse
    {
        $input = new UpdateUserRequest(
            $request->input('email'),
            $request->input('phone'),
            $request->input('name'),
            $request->input('preference'),
            $request->input('password'),
            $request->input('artist_type')
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Update User");
    }

    /**
     * @throws Exception
     */
    public function loginUser(Request $request, LoginUserService $service): JsonResponse
    {
        $input = new LoginUserRequest(
            $request->input('email'),
            $request->input('password')
        );
        $response = $service->execute($input);
        return $this->successWithData($response, "Berhasil Login");
    }

    /**
     * @throws Exception
     */
    public function me(Request $request, MeService $service): JsonResponse
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil Mengambil Data");
    }

    public function getUserList(Request $request, GetUserListService $service): JsonResponse
    {
        $input = new GetUserListRequest(
            $request->input('page'),
            $request->input('per_page'),
            $request->input('sort'),
            $request->input('type'),
            $request->input('filter'),
            $request->input('search')
        );

        $response = $service->execute($input);
        return $this->successWithData($response, "Berhasil Mendapatkan List User");
    }

    public function deleteUser(Request $request, DeleteUserService $service): JsonResponse
    {
        $input = new DeleteUserRequest(
            $request->input('user_id')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->success("User Berhasil diHapus");
    }

    /**
     * @throws Exception
     */
    public function changePassword(Request $request, ChangePasswordService $service): JsonResponse
    {
        $request->validate([
            'email' => 'email|email',
            'current_password' => 'min:8|max:64|string',
            'new_password' => 'min:8|max:64|string',
            're_password' => 'min:8|max:64|string'
        ]);

        $input = new ChangePasswordRequest(
            $request->input('email'),
            $request->input('current_password'),
            $request->input('new_password'),
            $request->input('re_password')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->success("Berhasil Merubah Password");
    }

    public function requestForgotPassword(Request $request, ForgotPasswordService $service): JsonResponse
    {
        $input = new ForgotPasswordRequest(
            new Email($request->input('email'))
        );
        $service->send($input);
        return $this->success("Berhasil Mengirim Permintan Mengganti Passsword");
    }

    public function changeForgotPassword(Request $request, ForgotPasswordService $service): JsonResponse
    {
        $request->validate([
            'token' => 'string',
            'password' => 'string|min:8|max:64',
            're_password' => 'string|min:8|max:64'
        ]);
        $input = new ChangeForgotPasswordRequest(
            $request->input('token'),
            $request->input('password'),
            $request->input('re_password')
        );

        DB::beginTransaction();
        try {
            $service->change($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->success("Berhasil Mengganti Passsword");
    }
}
