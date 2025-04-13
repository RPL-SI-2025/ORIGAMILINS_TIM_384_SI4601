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
        // Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',  
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
