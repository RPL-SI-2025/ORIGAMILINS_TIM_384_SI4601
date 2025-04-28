<?php

namespace Database\Seeders;

use App\Models\Pengrajin;
use Illuminate\Database\Seeder;

class PengrajinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample pengrajin data
        $pengrajinData = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'is_active' => true,
            ],
            [
                'nama' => 'Siti Rahayu', 
                'email' => 'siti@gmail.com',
                'is_active' => true,
            ],
            [
                'nama' => 'Dewi Wulandari', 
                'email' => 'dewi@gmail.com',
                'is_active' => true,
            ],
            [
                'nama' => 'Jamilah', 
                'email' => 'jamilah@gmail.com',
                'is_active' => true,
            ],
        ];

        foreach ($pengrajinData as $data) {
            // Check if the email already exists
            $existingPengrajin = Pengrajin::where('email', $data['email'])->first();
            
            if (!$existingPengrajin) {
                // Create pengrajin record
                Pengrajin::create([
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'is_active' => $data['is_active'],
                ]);
            }
        }
    }
}
