<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Produk;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminMenghapusProdukTest extends DuskTestCase
{
    /** @test */
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