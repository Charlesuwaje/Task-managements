<?php

namespace App\Modules\Services;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminService
{
    public function adminLogin(array $data): array
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    
        $admin = Admin::where('email', $data['email'])->first();
    
        if (! $admin || ! Hash::check($data['password'], $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }
    
        $token = $admin->createToken('admin-token')->plainTextToken;
    
        return [
            'admin' => $admin,
            'token' => $token,
        ];
    }
}    