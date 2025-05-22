<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Database\Seeders\UserSeeder;


class ProductReviewTest extends DuskTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /**
     * Test the product creation form loads correctly
     */
    public function testProductCreatePageLoads()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);
    }
    public function testViewUlasanProduk()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk')
        
                    ->pause(1000)
            
                    ->visit('/admin/product-reviews')
                    ->assertSee('Ulasan Produk')
                    ->click('@lihat-detail-button-21')
                    ->screenshot('pr-3');
        });
         
    }


    public function testEditUlasanProduk()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // $this->browse(function (Browser $browser) use ($admin) {
        //     $browser->visit('/login')
        //             ->pause(1000)
            
        //             ->visit('/admin/product-reviews')
        //             ->assertSee('Ulasan Produk')
        //             ->click('@lihat-detail-button-61')
        //             ->press('Setujui Ulasan')
        //             ->screenshot('pr-3');
        // });

        // $this->browse(function (Browser $browser) use ($admin) {
        //     $browser->visit('/login')
        //             ->pause(1000)
            
        //             ->visit('/admin/product-reviews')
        //             ->assertSee('Ulasan Produk')
        //             ->click('@lihat-detail-button-44')
        //             ->press('Tolak Ulasan')
        //             ->screenshot('pr-2');
        // });
         
    }
}
