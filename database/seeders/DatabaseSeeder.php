<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Paglikha ng admin user
        User::create([
            'name' => 'Admin User', // Pangalan ng admin
            'email' => 'admin@example.com', // Email ng admin
            'password' => bcrypt('password123'), // Password ng admin (gumamit ng bcrypt para sa hashing)
            'role' => 'admin', // Tiyakin na ang role ng user ay admin
        ]);

        // Optional: Gumawa ng test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user', // Regular user
        ]);
    }
}
