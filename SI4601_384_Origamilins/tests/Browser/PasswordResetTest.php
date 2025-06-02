<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User; // Pastikan model User Anda ada di App\Models\User

class PasswordResetTest extends DuskTestCase // Nama kelas diubah sesuai permintaan
{
    use DatabaseMigrations; // Trait ini akan me-reset database sebelum setiap test dijalankan.
    // Ini penting untuk memastikan test berjalan dalam kondisi yang bersih dan konsisten.

    /**
     * Test untuk alur lupa password, ubah password, dan login dengan password baru.
     * Alur:
     * 1. Kunjungi halaman utama, klik tombol "Masuk" di navigasi.
     * 2. Di halaman login, klik link "Lupa password?".
     * 3. Isi form reset password dengan email, password baru, dan konfirmasi password baru.
     * 4. Klik tombol "UBAH PASSWORD".
     * 5. Verifikasi bahwa pengguna kembali ke halaman login.
     * 6. Lakukan login menggunakan email dan password baru yang telah diatur.
     * 7. Verifikasi bahwa login berhasil dan pengguna diarahkan ke halaman etalase produk.
     *
     * @return void
     */
    public function testUserCanResetPasswordAndThenLogin(): void
    {
        // Langkah Persiapan: Buat user dummy untuk testing.
        // User ini diperlukan agar fitur "lupa password" dapat menemukan email yang terdaftar.
        $user = User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => bcrypt('passwordLama123'), // Password awal sebelum direset
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Langkah 1: Kunjungi halaman utama dan klik tombol "Masuk" di navigasi.
            // Ini akan mengarahkan pengguna ke halaman login.
            // Berdasarkan image_576518.jpg, tombol "Masuk" ada di header/navigasi.
            $browser->visit('/')
                ->click('a[data-url="http://127.0.0.1:8000/login"]'); // Asumsi tombol/link "Masuk" di navigasi utama.

            // Langkah 2: Di halaman login, klik link "Lupa password?".
            // Verifikasi bahwa kita berada di halaman login (/login) - sesuai image_5764d6.jpg.
            $browser->assertPathIs('/login') // Pastikan path halaman login benar
                ->clickLink('Lupa password?'); // Klik link "Lupa password?"

            // Langkah 3: Isi form reset password dan submit.
            // Verifikasi bahwa kita berada di halaman reset password - sesuai image_5712f8.png.
            // Path mungkin '/reset-password', '/password/reset', atau lainnya tergantung implementasi Anda.
            // Berdasarkan gambar image_5712f8.png, pathnya adalah /reset-password
            $browser->assertPathIs('/reset-password') // Pastikan path halaman reset password benar
                ->type('email', $user->email) // Isi field email dengan email user yang dibuat
                ->type('password', 'Indiff@123') // Isi field password baru
                ->type('password_confirmation', 'Indiff@123') // Isi field konfirmasi password baru
                ->press('UBAH PASSWORD'); // Klik tombol untuk mengubah password

            // Langkah 4: Verifikasi kembali ke halaman login setelah berhasil mengubah password.
            // Sesuai alur "kembali halaman login".
            // Berdasarkan gambar image_5712f8.png, setelah klik "UBAH PASSWORD", ada tombol "KEMBALI KE HALAMAN LOGIN"
            // Namun, alur yang diminta adalah langsung kembali ke halaman login setelah ubah password.
            // Jika aplikasi Anda mengarahkan ke halaman login secara otomatis setelah reset, baris ini benar.
            // Jika ada halaman perantara atau pesan sukses sebelum kembali ke login, sesuaikan.
            $browser->assertPathIs('/login');
            // Anda bisa menambahkan assertSee untuk pesan sukses jika ada, contoh:
            // ->waitForText('Password Anda telah berhasil diubah.', 5) // Tunggu pesan sukses
            // ->assertSee('Password Anda telah berhasil diubah. Silakan login.');

            // Langkah 5: Login dengan email dan password baru.
            // Pengguna sekarang berada di halaman login - sesuai image_5712bd.jpg.
            $browser->type('email', $user->email) // Isi field email
                ->type('password', 'Indiff@123') // Isi field password dengan password baru
                ->press('Masuk'); // Klik tombol "Masuk" pada form login

            // Langkah 6: Verifikasi berhasil login dan diarahkan ke halaman etalase produk.
            // Sesuai image_57129a.jpg.
            $browser->assertPathIs('/etalase-produk') // Pastikan path halaman etalase produk benar
                ->waitForText('Etalase Produk', 10) // Tunggu hingga teks "Etalase Produk" muncul (maks 10 detik)
                ->assertSee('Etalase Produk'); // Pastikan teks "Etalase Produk" ada di halaman
        });
    }
}
