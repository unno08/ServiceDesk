<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Default Users for Service Desk
        |--------------------------------------------------------------------------
        | Password for all users: password
        */

        User::updateOrCreate(
            ['email' => 'admin@aether.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'seller@aether.com'],
            [
                'name' => 'Seller',
                'password' => Hash::make('password'),
                'role' => 'seller',
            ]
        );

        User::updateOrCreate(
            ['email' => 'buyer@aether.com'],
            [
                'name' => 'Buyer',
                'password' => Hash::make('password'),
                'role' => 'buyer',
            ]
        );
    }
}
