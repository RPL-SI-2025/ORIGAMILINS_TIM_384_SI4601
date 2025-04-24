<?php

namespace Tests\Feature;

use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePesananTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $user;
    protected $pesanan;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create regular user
        $this->user = User::factory()->create([
            'role' => 'user'
        ]);

        // Create a test order
        $this->pesanan = Pesanan::factory()->create([
            'status' => 'Diproses'
        ]);
    }

    /** @test */
    public function admin_can_view_edit_pesanan_form()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.pesanan.edit', $this->pesanan->id_pesanan));

        $response->assertStatus(200)
            ->assertViewIs('admin.pesanan.edit')
            ->assertViewHas('pesanan')
            ->assertSee($this->pesanan->nama_pemesan)
            ->assertSee($this->pesanan->nama_produk)
            ->assertSee('Status Pesanan');
    }

    /** @test */
    public function non_admin_cannot_access_edit_pesanan_form()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.pesanan.edit', $this->pesanan->id_pesanan));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_pesanan_status()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.pesanan.update', $this->pesanan->id_pesanan), [
                'status' => 'Dikirim'
            ]);

        $response->assertRedirect(route('admin.pesanan.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $this->pesanan->id_pesanan,
            'status' => 'Dikirim'
        ]);
    }

    /** @test */
    public function pesanan_update_validates_required_status()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.pesanan.update', $this->pesanan->id_pesanan), []);

        $response->assertSessionHasErrors('status');
    }

    /** @test */
    public function pesanan_update_validates_status_enum()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.pesanan.update', $this->pesanan->id_pesanan), [
                'status' => 'Invalid Status'
            ]);

        $response->assertSessionHasErrors('status');
    }

    /** @test */
    public function pesanan_update_handles_nonexistent_pesanan()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.pesanan.update', 999), [
                'status' => 'Dikirim'
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function pesanan_update_preserves_other_fields()
    {
        $oldNamaPemesan = $this->pesanan->nama_pemesan;
        $oldNamaProduk = $this->pesanan->nama_produk;

        $response = $this->actingAs($this->admin)
            ->put(route('admin.pesanan.update', $this->pesanan->id_pesanan), [
                'status' => 'Selesai'
            ]);

        $response->assertRedirect(route('admin.pesanan.index'));
        
        $this->pesanan->refresh();
        $this->assertEquals($oldNamaPemesan, $this->pesanan->nama_pemesan);
        $this->assertEquals($oldNamaProduk, $this->pesanan->nama_produk);
        $this->assertEquals('Selesai', $this->pesanan->status);
    }

    /** @test */
    public function pesanan_update_updates_timestamp()
    {
        $oldUpdatedAt = $this->pesanan->updated_at;

        $response = $this->actingAs($this->admin)
            ->put(route('admin.pesanan.update', $this->pesanan->id_pesanan), [
                'status' => 'Dibatalkan'
            ]);

        $response->assertRedirect(route('admin.pesanan.index'));
        
        $this->pesanan->refresh();
        $this->assertNotEquals($oldUpdatedAt, $this->pesanan->updated_at);
    }

    /** @test */
    public function pesanan_update_handles_all_valid_statuses()
    {
        $validStatuses = ['Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];

        foreach ($validStatuses as $status) {
            $response = $this->actingAs($this->admin)
                ->put(route('admin.pesanan.update', $this->pesanan->id_pesanan), [
                    'status' => $status
                ]);

            $response->assertRedirect(route('admin.pesanan.index'))
                ->assertSessionHas('success');

            $this->assertDatabaseHas('pesanan', [
                'id_pesanan' => $this->pesanan->id_pesanan,
                'status' => $status
            ]);
        }
    }
} 