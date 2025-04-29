<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\PesananEvent;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Chrome;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Pengrajin;

class AdminUpdateStatusPesananEventTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_admin_can_view_pesanan_event_list()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                   ->visit('/admin/pesanan-event')
                   ->assertSee('Daftar Pesanan Event')
                   ->assertPresent('.pesanan-event-table');
        });
    }

    /** @test */
    public function test_admin_dapat_mengupdate_status_pesanan_event()
    {
        $this->browse(function (Browser $browser) {
            // Buat user admin
            $admin = User::factory()->create([
                'name' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => bcrypt('password123'),
                'role' => 'admin'
            ]);

            // Buat pesanan event untuk ditest
            $pesananEvent = PesananEvent::factory()->create([
                'status' => 'Menunggu'
            ]);

            $browser->loginAs($admin)
                   ->visit('/admin/pesanan-event/' . $pesananEvent->id_pesanan_event . '/edit')
                   ->assertSee('Edit Status Pesanan Event')
                   ->select('status', 'Belum Berjalan')
                   ->press('Update')
                   ->assertPathIs('/admin/pesanan-event')
                   ->assertSee('Status pesanan event berhasil diperbarui');
        });
    }

    public function test_admin_cannot_update_event_status_with_invalid_value()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $pesananEvent = PesananEvent::factory()->create([
            'status' => 'Menunggu'
        ]);

        $this->browse(function (Browser $browser) use ($admin, $pesananEvent) {
            $browser->loginAs($admin)
                   ->visit('/admin/pesanan-event/' . $pesananEvent->id_pesanan_event . '/edit')
                   ->assertSee('Edit Status Pesanan Event')
                   ->select('status', '')
                   ->press('Update Status')
                   ->assertSee('The status field is required');
        });
    }
} 