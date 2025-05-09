<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfilPenggunaTest extends DuskTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Nonaktifkan foreign key constraints
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tabel users
        User::truncate();

        // Aktifkan kembali foreign key constraints
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /** @test */
    public function test_profil_pengguna()
    {
        $user = User::factory()->create([
            'name' => 'Rafli Maulana',
            'email' => 'rafli@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $this->Membuka_halaman_pengguna($browser, $user);
        });
    }

    public function Membuka_halaman_pengguna(Browser $browser, User $user)
    {
        $browser->loginAs($user) // Login sebagai user
            ->visit('/profilpengguna') // Kunjungi halaman profil pengguna
            ->assertSee('Profil Pengguna') // Pastikan teks 'Profil Pengguna' terlihat
            ->assertSee('Photo Profil') // Pastikan teks 'Photo Profil' terlihat
            ->assertSee('Nama Lengkap') // Pastikan teks 'Nama Lengkap' terlihat
            ->assertSee('Nama Panggilan') // Pastikan teks 'Nama Panggilan' terlihat
            ->assertSee('Nomor Handphone') // Pastikan teks 'Nomor Handphone' terlihat
            ->assertSee('Email'); // Pastikan teks 'Email' terlihat
    }
    

    }