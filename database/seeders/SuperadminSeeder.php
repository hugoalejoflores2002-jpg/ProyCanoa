<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@canoa.test'],
            [
                'name' => 'Superadministrador',
                'password' => 'CanoaTemporal2026',
                'is_active' => true,
                'must_change_password' => false,
            ]
        );

        $user->syncRoles(UserRole::Superadmin->value);
    }
}