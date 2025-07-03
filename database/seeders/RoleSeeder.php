<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id' => (string) Str::ulid(),
                'name' => 'Super Admin',
                'description' => 'Full system access',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Admin',
                'description' => 'Manage teams and projects',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Support',
                'description' => 'Handles user queries and support tickets',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                [
                    'id' => $role['id'],
                    'description' => $role['description']
                ]
            );
        }
    }
}
