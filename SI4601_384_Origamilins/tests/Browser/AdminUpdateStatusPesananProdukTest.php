<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Pesanan;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Chrome;

class AdminUpdateStatusPesananProdukTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_admin_can_view_pesanan_produk_list()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                   ->visit('/admin/pesanan-produk')
                   ->assertSee('Daftar Pesanan Produk')
                   ->assertPresent('.pesanan-table');
        });
    }

    /** @test */
    public function test_admin_dapat_mengupdate_status_pesanan_produk()
    {
        $this->browse(function (Browser $browser) {
            // Buat user admin
            $admin = User::factory()->create([
                'name' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => bcrypt('password123'),
                'role' => 'admin'
            ]);

            // Buat pesanan untuk ditest
            $pesanan = Pesanan::factory()->create([
                'status' => 'Rencana'
            ]);

            $browser->loginAs($admin)
                   ->visit('/admin/pesanan-produk/' . $pesanan->id_pesanan . '/edit')
                   ->assertSee('Edit Status Pesanan')
                   ->select('status', 'Dalam Proses')
                   ->press('Update')
                   ->assertPathIs('/admin/pesanan-produk')
                   ->assertSee('Status pesanan berhasil diperbarui');
        });
    }

    public function test_admin_cannot_update_status_with_invalid_value()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $pesanan = Pesanan::factory()->create([
            'status' => 'Rencana'
        ]);

        $this->browse(function (Browser $browser) use ($admin, $pesanan) {
            $browser->loginAs($admin)
                   ->visit('/admin/pesanan-produk/' . $pesanan->id_pesanan . '/edit')
                   ->assertSee('Edit Status Pesanan')
                   ->select('status', '')
                   ->press('Update Status')
                   ->assertSee('The status field is required');
        });
    }
} 