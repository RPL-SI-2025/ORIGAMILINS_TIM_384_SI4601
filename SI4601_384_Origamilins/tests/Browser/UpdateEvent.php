<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Event;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateEvent extends DuskTestCase
{
    /** @test */
    public function test_admin_bisa_mengedit_event()
    {
        // Buat user admin
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);

        // Buat event
        $event = Event::factory()->create([
            'nama_event' => 'Workshop Origami',
            'deskripsi' => 'Workshop membuat origami untuk pemula',
            'tanggal_pelaksanaan' => '2024-12-31',
            'harga' => 150000,
            'lokasi' => 'Jakarta Convention Center',
            'kuota' => 50,
            'poster' => '/screenshots/event1.jpg', // Pastikan file ini ada atau gunakan default
        ]);

        $this->browse(function (Browser $browser) use ($admin, $event) {
            $browser->loginAs($admin)
                ->visit('/admin/event/' . $event->id . '/edit')
                ->assertSee('Edit Event')
                ->assertInputValue('nama_event', 'Workshop Origami')
                ->assertInputValue('deskripsi', 'Workshop membuat origami untuk pemula')
                ->assertInputValue('lokasi', 'Jakarta Convention Center')
                ->assertInputValue('harga', $event->harga)
                ->assertInputValue('kuota', $event->kuota)
                // Update data event
                ->type('nama_event', 'Origami Festival Update')
                ->type('deskripsi', 'Festival origami terbesar dan terbaru di Indonesia.')
                ->type('lokasi', 'Bandung')
                ->type('harga', '75000')
                ->type('kuota', '120')
                // ->attach('poster', __DIR__ . '/screenshots/event1.jpg')
                ->press('Update Event') 
                ->waitForLocation('/admin/event')
                ->assertSee('Origami Festival Update')
                ->assertSee('Event berhasil diperbarui!')
                ->screenshot('admin-edit-event');
        });
    }
}
