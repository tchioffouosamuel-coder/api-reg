<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@artiscode.agency'],
            [
                'name' => 'Admin ARTISCODE',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
            ]
        );

        // Test user for frontend
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
