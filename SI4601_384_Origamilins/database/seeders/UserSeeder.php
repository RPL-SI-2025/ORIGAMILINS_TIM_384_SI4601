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
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // User
        User::factory()->create([
            'name' => 'Ayu',
            'email' => 'ayu@gmail.com',
            'role' => 'user',  
        ]);
        User::factory()->create([
            'name' => 'Alda',
            'email' => 'alda@gmail.com',
            'role' => 'user',  
        ]);
        User::factory()->create([
            'name' => 'Hana',
            'email' => 'hana@gmail.com',
            'role' => 'user',  
        ]);
        User::factory()->create([
            'name' => 'Rafli',
            'email' => 'rafli@gmail.com',
            'role' => 'user',  
        ]);
        User::factory()->create([
            'name' => 'Fauzan',
            'email' => 'fauzan@gmail.com',
            'role' => 'user',  
        ]);
        User::factory()->create([
            'name' => 'Nabil',
            'email' => 'nabil@gmail.com',
            'role' => 'user',  
        ]);
    }
}
