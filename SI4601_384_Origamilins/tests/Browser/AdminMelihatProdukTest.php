<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminMelihatProdukTest extends DuskTestCase
{
    /** @test */
    /** @test */
public function test_admin_bisa_hapus_produk()
{
    $admin = User::factory()->create([
        'role' => 'admin',
        'email' => 'admin' . uniqid() . '@gmail.com',
    ]);

    $produk = \App\Models\Produk::factory()->create([
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
}}