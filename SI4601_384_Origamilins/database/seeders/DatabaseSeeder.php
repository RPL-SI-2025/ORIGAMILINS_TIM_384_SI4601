<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProdukSeeder::class,
            EventSeeder::class,
            ArtikelSeeder::class,
            EventReviewSeeder::class,
            ProductReviewSeeder::class,
            PesananSeeder::class,
            PesananEventSeeder::class,
        ]);
    }
}
