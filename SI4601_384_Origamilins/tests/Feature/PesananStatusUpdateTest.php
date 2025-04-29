<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Pengrajin;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PesananStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $produk;

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

        // Buat produk untuk digunakan di semua test
        $this->produk = new Produk();
        $this->produk->nama = 'Test Produk';
        $this->produk->nama_produk = 'Test Produk';
        $this->produk->harga = 100000;
        $this->produk->harga_dasar = 80000;
        $this->produk->kategori = 'Merchandise';
        $this->produk->ukuran = '5 x 5,10 x 10,15 x 15';
        $this->produk->deskripsi = 'Test deskripsi';
        $this->produk->save();
    }

    /** @test */
    public function admin_can_view_pesanan_index()
    {
        $pesanan = new Pesanan();
        $pesanan->user_id = $this->admin->id;
        $pesanan->produk_id = $this->produk->id;
        $pesanan->status = 'Rencana';
        $pesanan->ekspedisi = 'JNE';
        $pesanan->jumlah = 1;
        $pesanan->total_harga = $this->produk->harga * 1;
        $pesanan->alamat_pengiriman = 'Jl. Test No. 123';
        $pesanan->nomor_telepon = '081234567890';
        $pesanan->save();

        $response = $this->actingAs($this->admin)
                        ->get(route('admin.pesananproduk.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_view_edit_pesanan()
    {
        $pesanan = new Pesanan();
        $pesanan->user_id = $this->admin->id;
        $pesanan->produk_id = $this->produk->id;
        $pesanan->status = 'Rencana';
        $pesanan->ekspedisi = 'JNE';
        $pesanan->jumlah = 1;
        $pesanan->total_harga = $this->produk->harga * 1;
        $pesanan->alamat_pengiriman = 'Jl. Test No. 123';
        $pesanan->nomor_telepon = '081234567890';
        $pesanan->save();

        $response = $this->actingAs($this->admin)
                        ->get(route('admin.pesananproduk.edit', $pesanan->id_pesanan));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_update_status_pesanan()
    {
        $pesanan = new Pesanan();
        $pesanan->user_id = $this->admin->id;
        $pesanan->produk_id = $this->produk->id;
        $pesanan->status = 'Rencana';
        $pesanan->ekspedisi = 'JNE';
        $pesanan->jumlah = 1;
        $pesanan->total_harga = $this->produk->harga * 1;
        $pesanan->alamat_pengiriman = 'Jl. Test No. 123';
        $pesanan->nomor_telepon = '081234567890';
        $pesanan->save();

        $pengrajin = new Pengrajin();
        $pengrajin->nama = 'Test Pengrajin';
        $pengrajin->email = 'pengrajin@test.com';
        $pengrajin->is_active = true;
        $pengrajin->save();

        $response = $this->actingAs($this->admin)
                        ->put(route('admin.pesananproduk.update', $pesanan->id_pesanan), [
                            'status' => 'Dalam Proses',
                            'pengrajin_id' => $pengrajin->id,
                            'ekspedisi' => 'JNE',
                            'nama_produk' => $this->produk->nama_produk
                        ]);

        $response->assertRedirect(route('admin.pesananproduk.index'));

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'Dalam Proses',
            'pengrajin_id' => $pengrajin->id
        ]);
    }

    /** @test */
    public function guest_cannot_access_pesanan_management()
    {
        $pesanan = new Pesanan();
        $pesanan->user_id = $this->admin->id;
        $pesanan->produk_id = $this->produk->id;
        $pesanan->status = 'Rencana';
        $pesanan->ekspedisi = 'JNE';
        $pesanan->jumlah = 1;
        $pesanan->total_harga = $this->produk->harga * 1;
        $pesanan->alamat_pengiriman = 'Jl. Test No. 123';
        $pesanan->nomor_telepon = '081234567890';
        $pesanan->save();

        $response = $this->get(route('admin.pesananproduk.index'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('admin.pesananproduk.edit', $pesanan->id_pesanan));
        $response->assertRedirect(route('login'));

        $response = $this->put(route('admin.pesananproduk.update', $pesanan->id_pesanan), [
            'status' => 'Dalam Proses'
        ]);
        $response->assertRedirect(route('login'));
    }
} 