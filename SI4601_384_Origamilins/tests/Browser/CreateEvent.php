<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateEvent extends DuskTestCase
{
    /** @test */
    public function test_admin_dapat_menambah_event()
    {
        // Buat user admin untuk login
        User::where('email', 'like', 'admin%@gmail.com')->delete();
        $admin = User::factory()->create([
            'name' => 'admin',
            'role' => 'admin',
            'email' => 'admin'.uniqid().'@gmail.com'
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            // Login sebagai admin
            $browser->loginAs($admin)
                    // Kunjungi halaman tambah event
                    ->visit('/admin/event/create')
                    
                    // Isi form event
                    ->type('nama_event', 'Workshop Origami')
                    ->type('deskripsi', 'Workshop membuat origami untuk pemula')
                    ->type('tanggal_pelaksanaan', '2024-12-31')
                    ->type('harga', '150000')
                    ->type('lokasi', 'Jakarta Convention Center')
                    ->type('kuota', '50')
                    
                    // Upload poster - perbaiki path file
                    ->attach('poster', __DIR__ . '/screenshots/event1.jpg')
                    
                    // Submit form
                    ->press('Simpan Event')
                    
                    // Verifikasi hasil
                    ->assertPathIs('/admin/event')
                    ->assertSee('Workshop Origami')
                    ->assertSee('Event berhasil ditambahkan')
                    ->screenshot('admin-menambah-event-berhasil');
        });
    }

    /**
     * Test validasi form event
     *
     * @return void
     */
    public function test_validasi_form_event()
    {
        User::where('email', 'like', 'admin%@gmail.com')->delete();
        $admin = User::factory()->create([
            'name' => 'admin',
            'role' => 'admin',
            'email' => 'admin'.uniqid().'@gmail.com'
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/event/create')
                    ->press('Simpan Event');
                    
                    // Verifikasi pesan error
                    // ->assertSee('Please fill out this field')
                    // ->assertSee('Please fill out this field')
                    // ->assertSee('Please fill out this field')
                    // ->assertSee('Please fill out this field')
                    // ->assertSee('Please fill out this field')
                    // ->assertSee('Value must be greater than or equal  to 1.')
                    // ->assertSee('Please select a file.')
                    // ->screenshot('admin-menambah-event-validasi');
        });
    }
}
