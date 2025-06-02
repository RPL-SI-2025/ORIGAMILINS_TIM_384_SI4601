<?php

namespace Tests\Browser;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CartTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user dan produk dummy
        User::factory()->create([
            'email' => 'alda@gmail.com',
            'password' => bcrypt('password'),
        ]);
        Produk::create([
            'nama' => 'Burung Angsa',
            'harga' => 15000,
            'stok' => 10,
            'deskripsi' => 'Origami burung angsa yang elegan ini dilipat dengan rapi menggunakan kertas berkualitas, cocok sebagai hiasan meja, hadiah unik, atau simbol kasih sayang dan ketulusan.',
            'gambar' => 'https://origami.me/wp-content/uploads/2024/07/easy-origami-swan-1.jpg',
            'kategori' => 'Merchandise',
        ]);
    }

    /** @test */
    public function user_sees_empty_cart_message_when_cart_is_empty()
    {
        $user = User::first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/cart')
                ->assertSee('Keranjang Anda masih kosong.')
                ->assertSee('Belanja Sekarang');
        });
    }

    /** @test */
    public function user_can_add_product_to_cart_and_see_it()
    {
        $user = User::first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/produk/1')
                ->type('jumlah', '1')
                ->press('Tambahkan ke Keranjang')
                ->waitForText('Barang yang dipilih berhasil dimasukkan ke dalam keranjang', 5)
                ->assertSee('Barang yang dipilih berhasil dimasukkan ke dalam keranjang')
                ->press('Lanjut Belanja')
                ->visit('/cart')
                ->assertSee('Burung Angsa')
                ->assertSee('Rp 15.000')
                ->assertSee('Lanjut Ke Pembayaran');
        });
    }

    /** @test */
    public function user_can_increment_product_quantity_in_cart()
    {
        $user = User::first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/produk/1')
                ->type('jumlah', '1')
                ->press('Tambahkan ke Keranjang')
                ->waitForText('Barang yang dipilih berhasil dimasukkan ke dalam keranjang', 5)
                ->press('Lanjut Belanja')
                ->visit('/cart')
                // klik tombol tambah (form kedua di .quantity-controls)
                ->with('.cart-item', function ($row) {
                    $row->within('.quantity-controls', function ($controls) {
                        $controls->click('form:nth-of-type(2) .quantity-btn');
                    });
                })
                ->pause(1000)
                ->assertSeeIn('.cart-item .quantity-input', '2');
        });
    }

    /** @test */
    public function user_can_remove_product_from_cart()
    {
        $user = User::first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/produk/1')
                ->type('jumlah', '1')
                ->press('Tambahkan ke Keranjang')
                ->waitForText('Barang yang dipilih berhasil dimasukkan ke dalam keranjang', 5)
                ->press('Lanjut Belanja')
                ->visit('/cart')
                ->with('.cart-item', function ($row) {
                    $row->within('.quantity-controls', function ($controls) {
                        $controls->click('.delete-btn');
                    });
                })
                ->pause(1000)
                ->assertSee('Keranjang Anda masih kosong.');
        });
    }

    /** @test */
    public function user_adds_same_product_increases_quantity_not_new_row()
    {
        $user = User::first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/produk/1')
                ->type('jumlah', '1')
                ->press('Tambahkan ke Keranjang')
                ->waitForText('Barang yang dipilih berhasil dimasukkan ke dalam keranjang', 5)
                ->press('Lanjut Belanja')
                ->visit('/produk/1')
                ->type('jumlah', '1')
                ->press('Tambahkan ke Keranjang')
                ->waitForText('Barang yang dipilih berhasil dimasukkan ke dalam keranjang', 5)
                ->press('Lanjut Belanja')
                ->visit('/cart')
                ->assertSeeIn('.cart-item .quantity-input', '2');
        });
    }
}
