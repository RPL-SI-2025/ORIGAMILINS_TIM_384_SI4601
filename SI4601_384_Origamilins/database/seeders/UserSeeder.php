<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Create regular user if not exists
        if (!User::where('email', 'user@gmail.com')->exists()) {
            User::create([
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Create other users if they don't exist
        $users = [
            ['name' => 'Ayu', 'email' => 'ayu@gmail.com'],
            ['name' => 'Alda', 'email' => 'alda@gmail.com'],
            ['name' => 'Hana', 'email' => 'hana@gmail.com'],
            ['name' => 'Rafli', 'email' => 'rafli@gmail.com'],
            ['name' => 'Fauzan', 'email' => 'fauzan@gmail.com'],
            ['name' => 'Nabil', 'email' => 'nabil@gmail.com'],
        ];

        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                User::factory()->create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => 'user',
                ]);
            }
        }
    }
}
