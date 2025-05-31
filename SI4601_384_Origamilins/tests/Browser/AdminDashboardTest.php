<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class AdminDashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_interact_with_dashboard()
    {
        // Buat user admin dengan email dan password 
        $admin = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_admin' => true,
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            // Login sebagai admin
            $browser->visit('/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'password')
                ->press('Masuk')
                ->visit('/admin')
                ->screenshot('admin-dashboard-after-login')
                ->assertSee('Total Pesanan')
                ->assertSee('Total Produk')
                ->assertSee('Total Event')
                ->assertSee('Total Artikel');

            // Cek chart pendapatan dan produk
            $browser->assertPresent('canvas#pendapatanChart');

        });
    }
}