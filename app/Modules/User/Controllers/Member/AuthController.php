<?php

namespace App\Modules\User\Controllers\Member;
use Illuminate\Http\Request;
use App\Modules\Services\AuthService;
use App\Http\Controllers\ApiController;
use App\Modules\Services\MemberService;
use App\Modules\User\Resources\MemberResource;
use App\Modules\User\Requests\RegisterMemberRequest;


class AuthController extends ApiController
{
    public function __construct(public readonly AuthService $authService)
    {
    }

    public function register(RegisterMemberRequest $request)
    {
        $data = $this->authService->register($request->validated());

        return $this->success([
            'user' => new MemberResource($data['user']),
        ]);
    }

    public function login(Request $request)
    {
        $data = $this->authService->login($request->all());

        return $this->success([
            'admin' => new MemberResource($data['admin']),
            'token' => $data['token'],
        ]);
    }
}