<?php

namespace Tests\Feature;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArtikelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Buat user admin untuk testing
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);
    }

    /** @test */
    public function admin_can_view_artikel_index()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get(route('admin.artikel.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.artikel.index');
    }

    /** @test */
    public function admin_can_create_artikel()
    {
        $this->actingAs($this->admin);
        
        Storage::fake('public');
        
        $gambar = UploadedFile::fake()->image('artikel.jpg');
        
        $artikelData = [
            'judul' => $this->faker->sentence,
            'isi' => $this->faker->paragraph,
            'tanggal_publikasi' => now()->format('Y-m-d'),
            'gambar' => $gambar
        ];
        
        $response = $this->post(route('admin.artikel.store'), $artikelData);
        
        $response->assertRedirect(route('admin.artikel.index'));
        $this->assertDatabaseHas('artikel', [
            'judul' => $artikelData['judul'],
            'isi' => $artikelData['isi']
        ]);
        
        $artikel = Artikel::first();
        $this->assertNotNull($artikel->gambar);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $artikel->gambar));
    }

    /** @test */
    public function admin_can_view_artikel_detail()
    {
        $this->actingAs($this->admin);
        
        $artikel = Artikel::factory()->create();
        
        $response = $this->get(route('admin.artikel.show', $artikel->id_artikel));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.artikel.show');
        $response->assertViewHas('artikel');
    }

    /** @test */
    public function admin_can_update_artikel()
    {
        $this->actingAs($this->admin);
        
        $artikel = Artikel::factory()->create();
        
        Storage::fake('public');
        
        $gambarBaru = UploadedFile::fake()->image('artikel_update.jpg');
        
        $updateData = [
            'judul' => 'Judul Updated',
            'isi' => 'Isi Updated',
            'tanggal_publikasi' => now()->format('Y-m-d'),
            'gambar' => $gambarBaru
        ];
        
        $response = $this->put(route('admin.artikel.update', $artikel->id_artikel), $updateData);
        
        $response->assertRedirect(route('admin.artikel.index'));
        $this->assertDatabaseHas('artikel', [
            'id_artikel' => $artikel->id_artikel,
            'judul' => 'Judul Updated',
            'isi' => 'Isi Updated'
        ]);
    }

    /** @test */
    public function admin_can_delete_artikel()
    {
        $this->actingAs($this->admin);
        
        $artikel = Artikel::factory()->create();
        
        $response = $this->delete(route('admin.artikel.destroy', $artikel->id_artikel));
        
        $response->assertRedirect(route('admin.artikel.index'));
        $this->assertDatabaseMissing('artikel', ['id_artikel' => $artikel->id_artikel]);
    }

    /** @test */
    public function guest_cannot_access_artikel_management()
    {
        $response = $this->get(route('admin.artikel.index'));
        
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function validate_artikel_creation()
    {
        $this->actingAs($this->admin);
        
        $response = $this->post(route('admin.artikel.store'), []);
        
        $response->assertSessionHasErrors(['judul', 'isi', 'tanggal_publikasi', 'gambar']);
    }
} 