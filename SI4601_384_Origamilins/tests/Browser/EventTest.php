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

    /** @test */
    public function test_admin_can_create_event()
    {
        $admin = User::factory()->admin()->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                   ->visit('/admin/event/create')
                   ->assertSee('Tambah Event')
                   ->type('nama_event', 'Cerita Hari Ini - Mengulik Inovasi Barang Bekas')
                   ->type('deskripsi', 'Event ini akan menghadirkan sesi bincang santai bersama para inovator muda')
                   ->type('tanggal_pelaksanaan', '2025-04-30')
                   ->type('lokasi', 'Hotel Grand Cimahi')
                   ->type('harga', '19992')
                   ->type('kuota', '48')
                   ->attach('poster', public_path('uploads/artikel3.jpg'))
                   ->press('Simpan Event')
                   ->waitForLocation('/admin/event')
                   ->assertSee('Event berhasil ditambahkan!')
                   ->screenshot('admin-create-event');
        });
    }

    /** @test */
    public function test_admin_can_view_event_details()
    {
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->create();

        $this->browse(function (Browser $browser) use ($admin, $event) {
            $browser->loginAs($admin)
                   ->visit("/admin/event/{$event->id}")
                   ->assertSee('Detail Event')
                   ->assertSee($event->nama_event)
                   ->assertSee($event->lokasi)
                   ->assertSee('Rp ' . number_format($event->harga, 0, ',', '.'))
                   ->assertPresent('img[alt="Poster ' . $event->nama_event . '"]')
                   ->screenshot('admin-view-event');
        });
    }

    /** @test */
    public function test_admin_can_edit_event()
    {
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->create();

        $this->browse(function (Browser $browser) use ($admin, $event) {
            $browser->loginAs($admin)
                   ->visit("/admin/event/{$event->id}/edit")
                   ->assertSee('Edit Event')
                   ->assertInputValue('nama_event', $event->nama_event)
                   ->assertInputValue('deskripsi', $event->deskripsi)
                   ->assertInputValue('tanggal_pelaksanaan', $event->tanggal_pelaksanaan->format('Y-m-d'))
                   ->assertInputValue('lokasi', $event->lokasi)
                   ->assertInputValue('harga', $event->harga)
                   ->assertInputValue('kuota', $event->kuota)
                   ->type('nama_event', 'Workshop Origami: ' . $event->nama_event)
                   ->type('deskripsi', 'Workshop origami yang mengajak peserta untuk belajar seni melipat kertas sambil mendengarkan cerita inspiratif.')
                   ->type('lokasi', 'Aula ' . $event->lokasi)
                   ->type('harga', '25000')
                   ->type('kuota', '120')
                   ->press('Update Event')
                   ->waitForLocation('/admin/event')
                   ->assertSee('Event berhasil diperbarui!')
                   ->assertSee('Workshop Origami')
                   ->screenshot('admin-edit-event');
        });
    }

    /** @test */
    public function test_event_creation_validation()
    {
        $admin = User::factory()->admin()->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                   ->visit('/admin/event/create')
                   ->press('Simpan Event')
                   ->assertSee('nama event harus diisi')
                   ->assertSee('deskripsi harus diisi')
                   ->assertSee('tanggal pelaksanaan harus diisi')
                   ->assertSee('lokasi harus diisi')
                   ->assertSee('harga harus diisi')
                   ->assertSee('kuota harus diisi')
                   ->assertSee('poster harus diisi')
                   ->screenshot('event-validation');
        });
    }
}
