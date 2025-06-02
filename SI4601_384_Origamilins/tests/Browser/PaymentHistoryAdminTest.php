<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PaymentHistoryAdminTest extends DuskTestCase
{
 public function test_admin_can_view_payment_history()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk')
        
                    ->visit('/admin/payments')
                    ->assertSee('Riwayat Pembayaran')
                    ->assertSee('Total')
                    ->assertSee('Status')

                    ->click('table tbody tr:nth-child(1) td:last-child a')
                    ->assertSee('Detail Pembayaran')
                    ->assertSee('Status'); 
        });
    }


    public function testSearchFilter()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/payments')
                ->type('search', 'Fauzan') // Sesuaikan dengan name atau id input
                ->press('Filter')
                ->pause(1000) // tunggu Ajax jika perlu
                ->assertSee('Fauzan Taufiq') // Nama di tabel hasil
                ->assertSee('fauzan@gmail.com'); // Email user
        });
    }

    public function testStatusFilter()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/payments')
                ->select('status', 'pending') // 'pending' adalah value dari <option>
                ->press('Filter')
                ->pause(1000)
                ->assertSee('Menunggu Pembayaran');
        });
    }


        public function testTimeFilter()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/payments')
                    ->type('start_date', '31-05-2025')
                    ->type('end_date', '02-06-2025')
                    ->press('Filter')
                    ->pause(1000) // Tunggu filter selesai jika pakai JS
                    ->assertSee('02/06/2025'); // Pastikan hasil yang ditampilkan sesuai
        });
    }

     // Exception tests

        public function test_invalid_search_returns_no_results()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->visit('/login')
                    ->assertPathIs('/login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk')
        
                    ->visit('/admin/payments')
                    ->type('search', 'tidak tahu')
                    ->press('Filter')
                    ->pause(1000)
                    ->assertSee('Tidak ada data pembayaran'); 
        });
    }

        public function test_payment_detail_not_found()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/payments/999999') 
                    ->assertSee('404');
                    
        });
    }

            public function test_non_admin_cannot_access_payment_history()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->visit('/login')
                    ->assertPathIs('/login')
                    ->type('email', 'fauzan@gmail.com') // Regular user credentials
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->visit('/admin/payments')
                    ->assertDontSee('Riwayat Pembayaran');
                    
        });
    }
}
