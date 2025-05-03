<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfilPenggunaTest extends DuskTestCase
{
    /** @test */
    public function test_profil_pengguna()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email' => 'rafli' . uniqid() . '@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $uniqueEmail = 'rafli' . uniqid() . '@gmail.com';

            // 1. User membuka halaman profil pengguna
            $browser->loginAs($user)
                ->visit('/profilpengguna')
                ->assertSee('Profil Pengguna')
                ->assertSee('Photo Profil')
                ->assertSee('Nama Lengkap')
                ->assertSee('Nama Panggilan')
                ->assertSee('Nomor Handphone')
                ->assertSee('Email');

            // 2. User mengisi form dan simpan perubahan
            $browser->type('name', 'Nama Baru')
                ->type('nickname', 'Panggilan Baru')
                ->type('phone', '081234567890')
                ->type('email', $uniqueEmail)
                ->press('Simpan Perubahan')
                ->visit('/profilpengguna')
                ->assertInputValue('name', 'Nama Baru')
                ->assertInputValue('nickname', 'Panggilan Baru')
                ->assertInputValue('phone', '081234567890')
                ->assertInputValue('email', $uniqueEmail);

            // 3. Ubah nomor HP jadi valid lain, simpan, cek tampilannya
            $browser->type('phone', '1234567890')
                ->press('Simpan Perubahan')
                ->visit('/profilpengguna')
                ->assertInputValue('phone', '1234567890');

            // 4. Kosongkan nama lengkap, field lain valid, harus error
            $browser->type('name', '')
                ->type('nickname', 'Rafli')
                ->type('phone', '081234567890')
                ->type('email', $uniqueEmail)
                ->press('Simpan Perubahan')
                ->waitFor('@error-name', 10)
                ->assertPresent('@error-name');

            // 5. Upload foto > 512 KB, harus error
            $bigFile = \Illuminate\Http\UploadedFile::fake()->create('big.jpg', 600); // 600 KB
            $browser->type('name', 'Rafli Maulana')
                ->type('nickname', 'Rafli')
                ->type('phone', '081234567890')
                ->type('email', $uniqueEmail)
                ->attach('profile_photo', $bigFile->getPathname())
                ->press('Simpan Perubahan')
                ->waitForText('Ukuran foto profil maksimal 512KB', 10)
                ->assertSee('Ukuran foto profil maksimal 512KB');

            // 6. Upload file tipe tidak didukung, harus error
            $wrongFile = \Illuminate\Http\UploadedFile::fake()->create('file.pdf', 100, 'application/pdf');
            $browser->type('name', 'Rafli Maulana')
                ->type('nickname', 'Rafli')
                ->type('phone', '081234567890')
                ->type('email', $uniqueEmail)
                ->attach('profile_photo', $wrongFile->getPathname())
                ->press('Simpan Perubahan')
                ->waitForText('Format foto harus jpeg, png, atau jpg')
                ->assertSee('Format foto harus jpeg, png, atau jpg');
        });
    }
} 