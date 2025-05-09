<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Produk;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProdukTest extends DuskTestCase
{
    public function test_admin_melihat_produk()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);

        $produk = Produk::factory()->create([
            'nama' => 'Burung Angsa',
            'kategori' => 'Merchandise',
            'harga_dasar' => 15000,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $produk) {
            $browser->loginAs($admin)
                ->visit('/admin/produk')
                ->assertSee($produk->nama)
                ->click('.btn-danger')
                ->waitForText('Apakah Anda yakin?', 5)
                ->click('.swal2-confirm')
                ->waitForLocation('/admin/produk')
                ->pause(1000)
                ->screenshot('admin-hapus-produk');
        });
    }
    public function test_admin_bisa_mengedit_produk()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);

        $produk = Produk::factory()->create([
            'nama' => 'Burung Angsa',
            'kategori' => 'Merchandise',
            'harga_dasar' => 15000,
            'ukuran' => '10 x 10 cm,15 x 15 cm',
            'gambar' => 'https://origami.me/wp-content/uploads/2024/07/easy-origami-swan-1.jpg',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $produk) {
            $browser->loginAs($admin)
                ->visit('/admin/produk/' . $produk->id . '/edit')
                ->assertSee('Edit Produk')
                ->assertInputValue('nama', 'Burung Angsa')
                ->assertSelected('kategori', 'Merchandise')
                ->assertInputValue('harga_dasar', number_format($produk->harga_dasar, 0, ',', '.'))
                ->assertChecked('input[name="ukuran[]"][value="10 x 10 cm"]')
                ->assertChecked('input[name="ukuran[]"][value="15 x 15 cm"]')
                ->type('nama', 'Burung Angsa Edit')
                ->type('harga_dasar', '20000')
                ->uncheck('input[name="ukuran[]"][value="15 x 15 cm"]')
                ->check('input[name="ukuran[]"][value="20 x 20 cm"]')
                ->press('Update Produk')
                ->waitForLocation('/admin/produk')
                ->screenshot('admin-edit-produk');
        });
    }
    public function test_admin_bisa_menghapus_produk()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);

        $produk = Produk::factory()->create([
            'nama' => 'Burung Angsa',
            'kategori' => 'Merchandise',
            'harga_dasar' => 15000,
            'ukuran' => '10 x 10 cm,15 x 15 cm',
            'gambar' => 'https://origami.me/wp-content/uploads/2024/07/easy-origami-swan-1.jpg',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $produk) {
            $browser->loginAs($admin)
                ->visit('/admin/produk')
                ->assertSee($produk->nama)
                ->click('.btn-danger')
                ->waitForText('Apakah Anda yakin?', 5)
                ->click('.swal2-confirm')
                ->waitForLocation('/admin/produk')
                ->pause(1000)
                ->screenshot('admin-hapus-produk');
        });
    }
}
