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
    public function user_can_add_product_to_cart_and_see_success_popup()
    {
        // Buat user dan produk dummy
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
}