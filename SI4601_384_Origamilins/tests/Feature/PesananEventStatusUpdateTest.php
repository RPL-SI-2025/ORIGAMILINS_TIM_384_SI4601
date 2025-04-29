<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PesananEvent;
use App\Models\Pengrajin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PesananEventStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Buat user admin
        $this->admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }

    /** @test */
    public function admin_can_view_pesanan_event_index()
    {
        $pesanan = new PesananEvent();
        $pesanan->nama_pemesan = 'Test Pemesan';
        $pesanan->nama_event = 'Event Test';
        $pesanan->status = 'Menunggu';
        $pesanan->save();

        $response = $this->actingAs($this->admin)
                        ->get(route('admin.pesananevent.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_view_edit_pesanan_event()
    {
        $pesanan = new PesananEvent();
        $pesanan->nama_pemesan = 'Test Pemesan';
        $pesanan->nama_event = 'Event Test';
        $pesanan->status = 'Menunggu';
        $pesanan->save();

        $response = $this->actingAs($this->admin)
                        ->get(route('admin.pesananevent.edit', $pesanan->id_pesanan_event));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_update_status_pesanan_event()
    {
        $pesanan = new PesananEvent();
        $pesanan->nama_pemesan = 'Test Pemesan';
        $pesanan->nama_event = 'Event Test';
        $pesanan->status = 'Menunggu';
        $pesanan->save();

        $response = $this->actingAs($this->admin)
                        ->put(route('admin.pesananevent.update', $pesanan->id_pesanan_event), [
                            'status' => 'Belum Berjalan',
                            'nama_event' => $pesanan->nama_event
                        ]);

        $response->assertRedirect(route('admin.pesananevent.index'));

        $this->assertDatabaseHas('pesanan_event', [
            'id_pesanan_event' => $pesanan->id_pesanan_event,
            'status' => 'Belum Berjalan'
        ]);
    }

    /** @test */
    public function guest_cannot_access_pesanan_event_management()
    {
        $pesanan = new PesananEvent();
        $pesanan->nama_pemesan = 'Test Pemesan';
        $pesanan->nama_event = 'Event Test';
        $pesanan->status = 'Menunggu';
        $pesanan->save();

        $response = $this->get(route('admin.pesananevent.index'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('admin.pesananevent.edit', $pesanan->id_pesanan_event));
        $response->assertRedirect(route('login'));

        $response = $this->put(route('admin.pesananevent.update', $pesanan->id_pesanan_event), [
            'status' => 'Belum Berjalan'
        ]);
        $response->assertRedirect(route('login'));
    }
} 