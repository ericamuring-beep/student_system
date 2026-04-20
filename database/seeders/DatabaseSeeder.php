<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin User', 'password' => 'admin123', 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            ['name' => 'User Account', 'password' => 'user123', 'role' => 'user']
        );
    }
}
