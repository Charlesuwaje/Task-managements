<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(
            ['name' => 'Super Admin'],
            [
                'id' => (string) Str::ulid(),
                'description' => 'Full system access',
            ]
        );

        Admin::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Charles Uwaje',
                'password' => Hash::make('password'),
                'admin_role_id' => $role->id,
            ]
        );
    }
}
