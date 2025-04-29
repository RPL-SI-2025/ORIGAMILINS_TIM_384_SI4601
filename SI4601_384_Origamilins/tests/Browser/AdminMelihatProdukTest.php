<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminMelihatProdukTest extends DuskTestCase
{
    /** @test */
    public function test_admin_bisa_melihat_daftar_produk_dan_aksi()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/produk')
                ->assertSee('Daftar Produk')
                ->assertSee('Filter Produk')
                ->assertSee('Nama Produk')
                ->assertSee('Kategori')
                ->assertSee('Harga Dasar')
                ->assertSee('Ukuran')
                ->assertSee('Deskripsi')
                ->assertSee('Aksi')
                ->assertSee('Tambah Produk')
                ->assertSee('Cari')
                ->assertSee('Reset')
                ->assertSee('Burung Angsa')
                ->assertSee('Merchandise')
                ->assertSee('Rp 15.000')
                ->assertSee('View')
                ->assertSee('Edit')
                ->assertSee('Delete')
                ->screenshot('admin-melihat-produk-lengkap');
        });
    }
}