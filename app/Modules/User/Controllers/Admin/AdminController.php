<?php

namespace App\Modules\User\Controllers\Admin;
use Illuminate\Http\Request;
use App\Modules\Services\AdminService;
use App\Http\Controllers\ApiController;
use App\Modules\User\Resources\AdminResource;

class AdminController extends ApiController
{
    public function __construct(public readonly AdminService $adminService) {}


    public function login(Request $request)
    {
        $data = $this->adminService->adminLogin($request->all());

        return $this->success([
            'admin' => new AdminResource($data['admin']),
            'token' => $data['token'],
        ]);
    }
}
