<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Produk;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class PaymentTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function checkout_produk()
    {
        $user = User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $produk = Produk::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $produk) {
            // 1. Login sebagai user
            $browser->visit('/login')
                ->type('email', 'user@gmail.com')
                ->type('password', 'password')
                ->press('Masuk')
                // Perbaiki path sesuai hasil redirect setelah login
                ->assertPathIs('/etalase-produk');

            // 2. Pilih produk di etalase (misal halaman /katalog)
            $browser->visit('/katalog')
                ->assertSee($produk->nama)
                ->clickLink($produk->nama)
                ->assertPathIs('/produk/' . $produk->id)
                ->assertSee($produk->nama);

            // 3. Tekan tombol "Beli Sekarang"
            $browser->press('Beli Sekarang')
                ->pause(1000)
                ->assertPathIs('/cart')
                ->assertSee($produk->nama);

            // 4. Lanjut ke pembayaran
            $browser->press('Lanjut Ke Pembayaran')
                ->pause(1000)
                ->assertPathIs('/user/payments/create');

            // 5. Isi detail pengiriman
            $browser->type('nama_awal', 'ayu')
                ->type('nama_akhir', 'tri')
                ->type('email', 'ayutriy@gmail.com')
                ->type('phone_number', '08123456789')
                ->type('jalan', 'g66, g66, Cibiru, Merauke')
                ->select('kecamatan', 'Cibiru')
                ->select('opsi_pengiriman', 'Reguler')
                ->type('blok', 'g66')
                ->type('kota', 'Bandung')
                ->type('provinsi', 'Papua')
                ->type('kode_pos', '99616')
                ->check('alamat_invoice_sama')
                ->press('Lanjut')
                ->pause(1000)
                ->assertPathIs('/user/payments/shipping');

            // 6. Tampilkan detail produk & ringkasan pembayaran
            $browser->assertSee('Burung Angsa')
                ->assertSee('Subtotal')
                ->assertSee('Ongkir')
                ->assertSee('Total Pembayaran')
                ->assertSee('Alamat Pengiriman')
                ->assertSee('ayutriy@gmail.com')
                ->screenshot('payment-summary');
        });
    }

    /** @test */
    public function Validasi_eror()
    {
        $user = User::factory()->create([
            'email' => 'user2@gmail.com',
            'password' => bcrypt('password'),
        ]);
        // Ambil produk pertama yang ada di database
        $produk = Produk::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $produk) {
            $browser->visit('/login')
                ->type('email', 'user2@gmail.com')
                ->type('password', 'password')
                ->press('Masuk')
                ->assertPathIs('/etalase-produk');

            $browser->visit('/katalog')
                ->clickLink($produk->nama)
                ->press('Beli Sekarang')
                ->pause(1000)
                ->press('Lanjut Ke Pembayaran')
                ->pause(1000)
                // Kosongkan beberapa field wajib
                ->type('nama_awal', '')
                ->type('email', '')
                ->press('Lanjut')
                ->pause(1000)
                ->assertSee('nama_awal harus diisi')
                ->assertSee('email harus diisi');
        });
    }
}