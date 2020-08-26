<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAuth;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * 用户登录接口
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'auth_type' => 'required|string',
            'identifier' => 'required|string',
            'credential' => 'required|string',
        ]);

        $auth = UserAuth::whereType($request->input('auth_type'))
            ->whereIdentifier($request->input('identifier'))
            ->first();
        if (is_null($auth)) {
            return $this->failed('ERR_AUTH_MISMATCH', '用户不存在');
        }
        if (!Hash::check($request->input('credential'), $auth->credential)) {
            return $this->failed('ERR_AUTH_MISMATCH', '密码不正确');
        }
        $user = $auth->user_id;

        $payload = [
            'iss' => env('APP_URL'),
            'aud' => env('APP_URL'),
            'iat' => time(),
            'exp' => time() + 60 * 60 * 2,
            'sub' => $user,
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'));

        return $this->success([
            'token_type' => 'bearer',
            'access_token' => $token,
            'expired_in' => 60 * 60 * 2,
        ])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * 用户注册接口
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'auth_type' => 'required|string',
            'nickname' => 'required|string|unique:users',
            'identifier' => 'required|string|unique:user_auths',
            'credential' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::query()->create([
                'nickname' => $request->input('nickname'),
                'role_id' => 1,
            ]);

            $user->auths()->create([
                'user_id' => $user->id,
                'type' => $request->input('auth_type'),
                'identifier' => $request->input('identifier'),
                'credential' => $request->input('credential'),
            ]);
        });

        return $this->success()->setStatusCode(Response::HTTP_CREATED);
    }
}
