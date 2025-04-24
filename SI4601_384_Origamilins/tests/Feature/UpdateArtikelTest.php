<?php

namespace Tests\Feature;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateArtikelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $artikel;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create a test article
        $this->artikel = Artikel::factory()->create([
            'gambar' => 'uploads/artikel/test.jpg'
        ]);
    }

    /** @test */
    public function admin_can_view_edit_artikel_form()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.artikel.edit', $this->artikel->id_artikel));

        $response->assertStatus(200)
            ->assertViewIs('admin.artikel.edit')
            ->assertViewHas('artikel')
            ->assertSee($this->artikel->judul)
            ->assertSee($this->artikel->isi);
    }

    /** @test */
    public function non_admin_cannot_access_edit_artikel_form()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->get(route('admin.artikel.edit', $this->artikel->id_artikel));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_artikel_with_valid_data()
    {
        Storage::fake('public');

        $updateData = [
            'judul' => 'Updated Judul Artikel',
            'isi' => 'Updated Isi Artikel yang memiliki minimal 50 karakter untuk memenuhi validasi',
            'tanggal_publikasi' => now()->format('Y-m-d'),
            'gambar' => UploadedFile::fake()->image('updated.jpg', 800, 600)
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), $updateData);

        $response->assertRedirect(route('admin.artikel.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('artikel', [
            'id_artikel' => $this->artikel->id_artikel,
            'judul' => 'Updated Judul Artikel',
            'isi' => 'Updated Isi Artikel yang memiliki minimal 50 karakter untuk memenuhi validasi'
        ]);
    }

    /** @test */
    public function artikel_update_validates_required_fields()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), []);

        $response->assertSessionHasErrors([
            'judul' => 'The judul field is required.',
            'isi' => 'The isi field is required.',
            'tanggal_publikasi' => 'The tanggal publikasi field is required.'
        ]);
    }

    /** @test */
    public function artikel_update_validates_image_file()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => 'Test Judul',
                'isi' => 'Test Isi yang memiliki minimal 50 karakter untuk memenuhi validasi',
                'tanggal_publikasi' => now()->format('Y-m-d'),
                'gambar' => UploadedFile::fake()->create('document.pdf', 100)
            ]);

        $response->assertSessionHasErrors('gambar');
    }

    /** @test */
    public function artikel_update_validates_image_size()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => 'Test Judul',
                'isi' => 'Test Isi yang memiliki minimal 50 karakter untuk memenuhi validasi',
                'tanggal_publikasi' => now()->format('Y-m-d'),
                'gambar' => UploadedFile::fake()->image('large.jpg', 2000, 2000)->size(3000)
            ]);

        $response->assertSessionHasErrors('gambar');
    }

    /** @test */
    public function artikel_update_validates_title_length()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => str_repeat('a', 256),
                'isi' => 'Test Isi yang memiliki minimal 50 karakter untuk memenuhi validasi',
                'tanggal_publikasi' => now()->format('Y-m-d')
            ]);

        $response->assertSessionHasErrors('judul');
    }

    /** @test */
    public function artikel_update_validates_date_format()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => 'Test Judul',
                'isi' => 'Test Isi yang memiliki minimal 50 karakter untuk memenuhi validasi',
                'tanggal_publikasi' => 'invalid-date'
            ]);

        $response->assertSessionHasErrors('tanggal_publikasi');
    }

    /** @test */
    public function artikel_update_preserves_old_image_when_no_new_image_uploaded()
    {
        $oldImagePath = $this->artikel->gambar;
        
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => 'Updated Judul',
                'isi' => 'Updated Isi yang memiliki minimal 50 karakter untuk memenuhi validasi',
                'tanggal_publikasi' => now()->format('Y-m-d')
            ]);

        $response->assertRedirect(route('admin.artikel.index'));
        
        $this->artikel->refresh();
        $this->assertEquals($oldImagePath, $this->artikel->gambar);
    }

    /** @test */
    public function artikel_update_validates_content_minimum_length()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => 'Test Judul',
                'isi' => 'Too short',
                'tanggal_publikasi' => now()->format('Y-m-d')
            ]);

        $response->assertSessionHasErrors('isi');
    }

    /** @test */
    public function artikel_update_validates_future_publication_date()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => 'Test Judul',
                'isi' => 'Test Isi yang memiliki minimal 50 karakter untuk memenuhi validasi',
                'tanggal_publikasi' => now()->addDays(1)->format('Y-m-d')
            ]);

        $response->assertSessionHasErrors('tanggal_publikasi');
    }

    /** @test */
    public function artikel_update_validates_special_characters_in_title()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => 'Test Judul @#$%^&*()',
                'isi' => 'Test Isi yang memiliki minimal 50 karakter untuk memenuhi validasi',
                'tanggal_publikasi' => now()->format('Y-m-d')
            ]);

        $response->assertSessionHasErrors('judul');
    }

    /** @test */
    public function artikel_update_allows_safe_html_content()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.artikel.update', $this->artikel->id_artikel), [
                'judul' => 'Test Judul',
                'isi' => '<p>Test Isi dengan <strong>HTML</strong> yang <em>aman</em> dan memiliki minimal 50 karakter</p>',
                'tanggal_publikasi' => now()->format('Y-m-d')
            ]);

        $response->assertRedirect(route('admin.artikel.index'));
        
        $this->artikel->refresh();
        $this->assertStringContainsString('<p>', $this->artikel->isi);
        $this->assertStringContainsString('<strong>', $this->artikel->isi);
        $this->assertStringContainsString('<em>', $this->artikel->isi);
    }
} 