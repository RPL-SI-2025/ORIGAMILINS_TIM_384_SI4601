<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Event;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // Run migrations
        $this->artisan('migrate:fresh');
        
        // Run seeders
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
        
        // Create admin user
        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }

    /**
     * Test creating a new event.
     */
    public function test_admin_can_create_event(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                   ->type('email', 'admin@gmail.com')
                   ->type('password', 'password')
                   ->press('LOG IN')
                   ->assertPathIs('/dashboard')
                   
                   // Navigate to event creation page
                   ->visit('/admin/event/create')
                   ->assertSee('Tambah Event')
                   
                   // Fill in the event form
                   ->type('nama_event', 'Cerita Hari Ini - Mengulik Inovasi Barang Bekas')
                   ->type('deskripsi', 'Event ini akan menghadirkan sesi bincang santai bersama para inovator muda')
                   ->type('tanggal_pelaksanaan', '2025-04-30')
                   ->type('lokasi', 'Hotel Grand Cimahi')
                   ->type('harga', '19992')
                   ->type('kuota', '48')
                   ->attach('poster', public_path('uploads/artikel3.jpg'))
                   
                   // Submit the form
                   ->press('Simpan Event')
                   
                   // Assert success
                   ->assertPathIs('/admin/event')
                   ->assertSee('Event berhasil ditambahkan!');
        });
    }

    /**
     * Test viewing event details.
     */
    public function test_admin_can_view_event_details(): void
    {
        $event = Event::where('nama_event', 'Melipat Kertas, Merangkai Cerita')->first();

        $this->browse(function (Browser $browser) use ($event) {
            $browser->visit('/login')
                   ->type('email', 'admin@gmail.com')
                   ->type('password', 'password')
                   ->press('LOG IN')
                   
                   // Visit event details page
                   ->visit("/admin/event/{$event->id}")
                   ->assertSee('Detail Event')
                   ->assertSee('Melipat Kertas, Merangkai Cerita')
                   ->assertSee('SMK 1 Cimahi')
                   ->assertSee('Rp 20.000')
                   ->assertPresent('img[alt="Poster ' . $event->nama_event . '"]');
        });
    }

    /**
     * Test editing an event.
     */
    public function test_admin_can_edit_event(): void
    {
        $event = Event::where('nama_event', 'Melipat Kertas, Merangkai Cerita')->first();

        $this->browse(function (Browser $browser) use ($event) {
            $browser->visit('/login')
                   ->type('email', 'admin@gmail.com')
                   ->type('password', 'password')
                   ->press('LOG IN')
                   
                   // Visit edit page
                   ->visit("/admin/event/{$event->id}/edit")
                   ->assertSee('Edit Event')
                   
                   // Update form fields with realistic data
                   ->type('nama_event', 'Workshop Origami: Melipat Kertas, Merangkai Cerita')
                   ->type('deskripsi', 'Workshop origami yang mengajak peserta untuk belajar seni melipat kertas sambil mendengarkan cerita inspiratif.')
                   ->type('lokasi', 'Aula SMK 1 Cimahi')
                   ->type('harga', '25000')
                   ->type('kuota', '120')
                   
                   // Submit the form
                   ->press('Update Event')
                   
                   // Assert success
                   ->assertPathIs('/admin/event')
                   ->assertSee('Event berhasil diperbarui!')
                   ->assertSee('Workshop Origami');
        });
    }

    /**
     * Test validation errors when creating event.
     */
    public function test_event_creation_validation(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                   ->type('email', 'admin@gmail.com')
                   ->type('password', 'password')
                   ->press('LOG IN')
                   
                   // Try to submit empty form
                   ->visit('/admin/event/create')
                   ->press('Simpan Event')
                   
                   // Assert validation errors
                   ->assertSee('nama event harus diisi')
                   ->assertSee('deskripsi harus diisi')
                   ->assertSee('tanggal pelaksanaan harus diisi')
                   ->assertSee('lokasi harus diisi')
                   ->assertSee('harga harus diisi')
                   ->assertSee('kuota harus diisi')
                   ->assertSee('poster harus diisi');
        });
    }
}
