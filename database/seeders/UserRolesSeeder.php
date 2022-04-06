<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Create the seller role
        UserRole::create([
            'roleName' => UserRole::ROLES['SELLER']
        ]);

        // Create the buyer role
        UserRole::create([
            'roleName' => UserRole::ROLES['BUYER']
        ]);

    }
}
