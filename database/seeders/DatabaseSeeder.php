<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Role - Full Access (Create, Update, Delete)
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin User', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        // Teacher Role - View Only
        User::updateOrCreate(
            ['email' => 'teacher@gmail.com'],
            ['name' => 'Teacher Account', 'password' => Hash::make('teacher123'), 'role' => 'teacher']
        );

        // Student Role - Limited Access
        User::updateOrCreate(
            ['email' => 'student@gmail.com'],
            ['name' => 'Student Account', 'password' => Hash::make('student123'), 'role' => 'student']
        );

        // Instructor Role - View Only (separate from Teacher)
        User::updateOrCreate(
            ['email' => 'instructor@gmail.com'],
            ['name' => 'Instructor Account', 'password' => Hash::make('instructor123'), 'role' => 'instructor']
        );
    }
}
