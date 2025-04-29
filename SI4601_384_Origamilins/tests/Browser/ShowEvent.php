<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Event;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowEvent extends DuskTestCase
{
    /** @test */
    public function test_admin_bisa_melihat_detail_event()
    {
        // Buat user admin
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);

        // Buat event
        $event = Event::factory()->create([
            'nama_event' => 'Origami Festival',
            'deskripsi' => 'Festival origami terbesar di Indonesia.',
            'tanggal_pelaksanaan' => now()->addDays(10),
            'harga' => 50000,
            'lokasi' => 'Jakarta',
            'kuota' => 100,
            'kuota_terisi' => 25,
            'poster' => 'uploads/event/test-poster.jpg', // Pastikan file ini ada atau gunakan default
        ]);

        $this->browse(function (Browser $browser) use ($admin, $event) {
            $browser->loginAs($admin)
                ->visit('/admin/event/' . $event->id)
                ->assertSee('Detail Event')
                ->assertSee($event->nama_event)
                ->assertSee($event->deskripsi)
                ->assertSee($event->lokasi)
                ->assertSee('Rp ' . number_format($event->harga, 0, ',', '.'))
                ->assertSee($event->kuota_terisi . '/' . $event->kuota . ' Peserta')
                ->assertSee('Tersisa ' . ($event->kuota - $event->kuota_terisi) . ' kursi')
                ->screenshot('admin-melihat-detail-event');
        });
    }
}
