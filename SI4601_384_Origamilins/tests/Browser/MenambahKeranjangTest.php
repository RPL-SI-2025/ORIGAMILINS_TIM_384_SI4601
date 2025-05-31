<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Produk;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MenambahKeranjangTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_menambah_produk_ke_keranjang()
    {
        $user = User::factory()->create();
        $produk = Produk::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $produk) {
            $browser->loginAs($user)
                ->visit(route('detail.produk', $produk->id))
                ->assertSee($produk->nama)
                ->assertPresent('form#add-to-cart-form')
                ->press('Tambahkan ke Keranjang')
                ->pause(1000) 
                ->assertVisible('#cart-success-popup')
                ->assertSee('Barang yang dipilih berhasil')
                ->click('#lanjut-belanja-btn')
                ->pause(500)
                ->assertMissing('#cart-success-popup');
                 });
    }

     public function user_bisa_update_kuantitas_produk_di_keranjang()
    {
        $user = User::factory()->create();
        $produk = Produk::factory()->create(['stok' => 10]);

        $this->browse(function (Browser $browser) use ($user, $produk) {
            // Tambah produk ke keranjang dulu
            $browser->loginAs($user)
                ->visit(route('detail.produk', $produk->id))
                ->press('Tambahkan ke Keranjang')
                ->pause(1000)
                ->visit('/cart')
                ->assertSee($produk->nama)
                // Tambah kuantitas
                ->press('@btn-tambah-kuantitas') 
                ->pause(500)
                ->assertInputValue('input[name="kuantitas"]', 2)
                // Kurangi kuantitas
                ->press('@btn-kurang-kuantitas')
                ->pause(500)
                ->assertInputValue('input[name="kuantitas"]', 1);
        });
    }

    /** @test */
    public function user_bisa_menghapus_produk_dari_keranjang()
    {
        $user = User::factory()->create();
        $produk = Produk::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $produk) {
            // Tambah produk ke keranjang dulu
            $browser->loginAs($user)
                ->visit(route('detail.produk', $produk->id))
                ->press('Tambahkan ke Keranjang')
                ->pause(1000)
                ->visit('/cart')
                ->assertSee($produk->nama)
                // Hapus produk dari keranjang
                ->screenshot('cart-before-delete')
                ->press('@btn-hapus-produk-' . $produk->id)
                ->pause(500)
                ->assertDontSee($produk->nama);
        });
    }
    }