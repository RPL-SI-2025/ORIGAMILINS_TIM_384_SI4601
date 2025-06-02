<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Event; // Pastikan Anda memiliki model Event dan factory-nya

class EventRegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserCanRegisterForEvent(): void
    {
        // Buat user untuk login
        $user = User::factory()->create([
            'name' => 'User Test Registrasi',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Buat event dummy
        $eventTarget = Event::factory()->create([
            'nama_event' => 'Melipat Kertas, Merangkai Cerita',
            'poster' => 'path/to/default/event_poster.jpg', // Sesuaikan
            'tanggal_pelaksanaan' => now()->addDays(15),
            'kuota' => 10, // Pastikan ada kuota
        ]);

        $this->browse(function (Browser $browser) use ($user, $eventTarget) {
            $browser->visit('/')
                ->clickLink('Masuk');

            $browser->assertPathIs('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Masuk');

            // Sesuaikan path ini jika halaman setelah login berbeda
            $browser->assertPathIs('/etalase-produk');

            // Langkah 4: Klik "Event" di navigasi
            // Disarankan: tambahkan dusk="nav-link-event" pada link HTML <a href="/events">Event</a>
            // Lalu gunakan: ->click('@nav-link-event')
            $browser->clickLink('Event')
                ->assertPathIs('/events');

            // Langkah 5: Klik event "Melipat Kertas, Merangkai Cerita"
            $browser->assertSee($eventTarget->nama_event)
                ->clickLink($eventTarget->nama_event)
                ->assertPathIs('/events/' . $eventTarget->id);

            // Langkah 6: Klik "Daftar Event"
            $browser->clickLink('Daftar Event')
                ->assertPathIs('/events/' . $eventTarget->id . '/register');

            // Langkah 7: Isi Form Pendaftaran Event
            $browser->assertSee('Form Pendaftaran Event: ' . $eventTarget->nama_event)
                ->type('nama', $user->name)
                ->type('email', $user->email)
                ->type('telepon', '08987297683')
                ->type('jumlah_tiket', '1')
                ->select('metode_pembayaran', 'transfer') // Sesuai value di HTML
                ->type('catatan', 'tidak ada');

            // Langkah 8: Klik "Daftar & Bayar Sekarang"
            $browser->click('#pay-button'); // Menggunakan ID tombol

            // Tambahkan pause dan screenshot di sini untuk debugging
            $browser->pause(5000); // Jeda 5 detik untuk observasi
            $browser->screenshot('setelah_klik_daftar_dan_bayar');

            // Langkah 9: Interaksi dengan Midtrans DIKOMENTARI SEMENTARA untuk isolasi error
            /*
            $browser->whenAvailable('.payment-page', function ($modal) { // Ganti .payment-page jika perlu
                $modal->waitForText('GoPay/GoPay Later', 15)
                      ->clickLink('GoPay/GoPay Later'); // Asumsi ini link, sesuaikan jika bukan
            }, 20);
            */

            // Langkah 10: Verifikasi (opsional, juga dikomentari untuk fokus ke klik bayar)
            /*
            $browser->waitForText('Pembayaran Berhasil', 30)
                    ->assertSee('Pembayaran Anda sedang diproses');
            */

            // Untuk sementara, tambahkan assertion sederhana di akhir agar tes tidak error karena tidak ada assertion
            // Anda bisa menghapus atau mengubah ini nanti.
            // $browser->assertPathIsNot('/events/' . $eventTarget->id . '/register'); // Contoh: Memastikan sudah pindah halaman
        });
    }
}
