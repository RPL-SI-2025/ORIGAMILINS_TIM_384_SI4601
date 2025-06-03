<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Produk; 
use Database\Seeders\UserSeeder;
use Database\Seeders\ProdukSeeder;
use Database\Seeders\PesananSeeder;
use Illuminate\Support\Facades\Artisan;

class PesananNotificationTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Refresh database dan jalankan seeder
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    /**
     * Test alur notifikasi pesanan dari login hingga pesanan selesai.
     */
    public function testUserFlowPesananNotification()
    {
        // Get seeded data
        $user = User::where('email', 'hana@gmail.com')->first();
        $pesanan = Pesanan::where('status', 'Dikirim')->first();

        $this->browse(function (Browser $browser) use ($user, $pesanan) {
            // Langkah 1: Login
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Masuk')
                ->assertPathIs('/etalase-produk');

            // Langkah 2: Buka dropdown notifikasi
            $browser->click('#notificationDropdown')
                ->waitFor('.dropdown-menu', 10)
                ->assertSee('Status: Dikirim')
                ->assertSee('Pesanan ID: #' . $pesanan->id_pesanan);

            // Langkah 3: Klik notifikasi (link ke detail pesanan)
            $browser->clickLink('Status: Dikirim')
                ->assertPathIs('/my-orders/' . $pesanan->id_pesanan);

            // Langkah 4: Konfirmasi pesanan diterima di halaman detail
            $browser->press('Konfirmasi Pesanan Diterima')
                ->assertSee('Pesanan telah dikonfirmasi diterima.');

            // Langkah 5: Isi ulasan produk
            $browser->assertPathIs('/pesanan/' . $pesanan->id_pesanan . '/ulasan')
                ->select('rating', 5)
                ->type('ulasan', 'Produk sangat bagus dan sesuai deskripsi.')
                ->press('Kirim Ulasan')
                ->assertSee('Terima kasih atas ulasan Anda!');

            // Langkah 6: Verifikasi status selesai
            $browser->assertPathIs('/my-orders/' . $pesanan->id_pesanan)
                ->assertSee('Selesai');
        });
    }
}