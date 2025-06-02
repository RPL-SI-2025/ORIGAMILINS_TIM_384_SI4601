<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RefundAdminTest extends DuskTestCase
{
   public function test_admin_can_view_refund()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk')
        
                    ->visit('/admin/refunds')
                    ->assertSee('Manajemen Refund')
                    ->assertSee('Total')
                    ->assertSee('Status')

                    ->click('table tbody tr:nth-child(1) td:last-child a')
                    ->assertSee('Detail Refund')
                    ->assertSee('Status'); 
        });
    }

       public function testSearchFilter()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/refunds')
                ->type('search', 'Hana') // Sesuaikan dengan name atau id input
                ->press('Filter')
                ->pause(1000) // tunggu Ajax jika perlu
                ->assertSee('Hana') ;// Nama di tabel hasil
        });
    }

        public function testStatusFilter()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/refunds')
                ->select('status', 'refund_requested') 
                ->press('Filter')
                ->pause(1000)
                ->assertSee('Menunggu Refund');
        });
    }

        public function testTimeFilter()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/refunds')
                    ->type('start_date', '31-05-2025')
                    ->type('end_date', '02-06-2025')
                    ->press('Filter')
                    ->pause(1000) // Tunggu filter selesai jika pakai JS
                    ->assertSee('01/06/2025'); // Pastikan hasil yang ditampilkan sesuai
        });
    }


// Exception tests

        public function test_invalid_search_returns_no_results()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/payments')
                    ->type('search', 'tidak tahu')
                    ->press('Filter')
                    ->pause(1000)
                    ->assertSee('Tidak ada data pembayaran'); 
        });
    }

        public function test_refund_detail_not_found()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/refunds/999999') 
                    ->assertSee('404');
                    
        });
    }


        public function test_non_admin_cannot_access_refund_mangement()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->visit('/login')
                    ->assertPathIs('/login')
                    ->type('email', 'fauzan@gmail.com') // Regular user credentials
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->visit('/admin/refunds')
                    ->assertDontSee('Manajemen Refund');
                    
        });
    }
}
