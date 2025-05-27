<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as DuskTestCase;

class AdminDashboardTest extends DuskTestCase
{
    /**
     * Test admin dashboard loads and displays key stats.
     *
     * @return void
     */
    public function test_admin_can_see_dashboard_stats()
    {
        $this->browse(function (Browser $browser) {
            // Login as admin (pastikan ada user admin di database)
            $admin = User::where('is_admin', 1)->first();
            $browser->loginAs($admin)
                ->visit('/admin/dashboard')
                ->assertSee('Total Pesanan')
                ->assertSee('Total Produk')
                ->assertSee('Total Event')
                ->assertSee('Total Artikel')
                ->assertSee('Penjualan Produk')
                ->assertSee('Perbandingan Pendapatan')
                ->assertSee('Verifikasi Pembayaran')
                ->assertSee('Produk Terlaris Bulan Ini')
                ->assertSee('Kalender Event')
                // Cek chart canvas ada
                ->assertPresent('canvas#penjualanChart')
                ->assertPresent('canvas#pendapatanChart')
                ->assertPresent('canvas#verifikasiChart')
                // Cek tombol filter chart
                ->assertPresent('#btnThisYear')
                ->assertPresent('#btnLastMonth')
                ->assertPresent('#btnCompare');
        });
    }
}