<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class KonfigurasiHakAksesTest extends DuskTestCase
{
    /** @test */
    public function test_hak_akses_admin_dan_user()
    {
        // Buat user admin
        $admin = User::factory()->create([
            'email' => 'admin' . uniqid() . '@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        // Buat user biasa
        $user = User::factory()->create([
            'email' => 'user' . uniqid() . '@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'email_verified_at' => now()
        ]);

        $this->browse(function (Browser $browser) use ($admin, $user) {
            // Test 1: Admin berhasil login dan hanya bisa akses halaman admin
            $browser->visit('/login')
                ->type('email', $admin->email)
                ->type('password', 'password')
                ->press('Masuk')
                ->assertPathIs('/admin') // Pastikan redirect ke halaman admin
                ->assertSee('Dashboard') // Pastikan bisa lihat konten admin
                ->assertDontSee('User Dashboard') // Pastikan tidak bisa lihat konten user
                ->click('a[href="' . route('logout') . '"]') // Klik link logout
                ->assertPathIs('/');

            // Test 2: User berhasil login dan hanya bisa akses halaman user
            $browser->visit('/login')
                ->pause(500)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Masuk')
                ->screenshot('debug-login-user')
                ->assertTrue(in_array($browser->path(), ['dashboard', 'login']))
                ->assertSee('User Dashboard') // Pastikan bisa lihat konten user
                ->assertDontSee('Admin Dashboard') // Pastikan tidak bisa lihat konten admin
                ->click('a[href="' . route('logout') . '"]') // Klik link logout
                ->assertPathIs('/');

            // Test 3: User mencoba akses halaman admin (harus diredirect)
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Masuk')
                ->visit('/admin') // Coba akses halaman admin
                ->assertPathIs('/dashboard') // Harus diredirect ke halaman user
                ->assertSee('Unauthorized') // Pastikan muncul pesan unauthorized
                ->click('a[href="' . route('logout') . '"]') // Klik link logout
                ->assertPathIs('/');
        });
    }
} 