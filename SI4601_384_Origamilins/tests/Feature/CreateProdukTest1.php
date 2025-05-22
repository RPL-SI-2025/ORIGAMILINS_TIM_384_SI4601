<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateProdukTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);
    }

    /** @test */
    public function admin_can_view_create_product_form()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.produk.create'));

        $response->assertStatus(200)
            ->assertViewIs('admin.produk.create')
            ->assertSee('Tambah Produk Baru')
            ->assertSee('Nama Produk')
            ->assertSee('Kategori')
            ->assertSee('Harga')
            ->assertSee('Gambar Produk')
            ->assertSee('Deskripsi');
    }

    /** @test */
    public function non_admin_cannot_access_create_product_form()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->get(route('admin.produk.create'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_create_new_product_with_valid_data()
    {
        Storage::fake('public');

        $productData = [
            'nama' => 'Origami Bunga',
            'kategori' => 'Dekorasi',
            'harga' => 50000,
            'deskripsi' => 'Origami bunga cantik untuk dekorasi',
            'gambar' => UploadedFile::fake()->image('origami.jpg', 800, 600)
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.produk.store'), $productData);

        $response->assertRedirect(route('admin.produk.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('produk', [
            'nama' => 'Origami Bunga',
            'kategori' => 'Dekorasi',
            'harga' => 50000,
            'deskripsi' => 'Origami bunga cantik untuk dekorasi'
        ]);

        Storage::disk('public')->assertExists('products/' . $productData['gambar']->hashName());
    }

    /** @test */
    public function product_creation_validates_required_fields()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.produk.store'), []);

        $response->assertSessionHasErrors([
            'nama' => 'The nama field is required.',
            'kategori' => 'The kategori field is required.',
            'harga' => 'The harga field is required.',
            'deskripsi' => 'The deskripsi field is required.'
        ]);
    }

    /** @test */
    public function product_creation_validates_image_file()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.produk.store'), [
                'nama' => 'Origami Test',
                'kategori' => 'Dekorasi',
                'harga' => 50000,
                'deskripsi' => 'Test deskripsi',
                'gambar' => UploadedFile::fake()->create('document.pdf', 100)
            ]);

        $response->assertSessionHasErrors('gambar');
    }

    /** @test */
    public function product_creation_validates_price_format()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.produk.store'), [
                'nama' => 'Origami Test',
                'kategori' => 'Dekorasi',
                'harga' => 'invalid-price',
                'deskripsi' => 'Test deskripsi'
            ]);

        $response->assertSessionHasErrors('harga');
    }

    /** @test */
    public function product_creation_validates_category_options()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.produk.store'), [
                'nama' => 'Origami Test',
                'kategori' => 'Invalid Category',
                'harga' => 50000,
                'deskripsi' => 'Test deskripsi'
            ]);

        $response->assertSessionHasErrors('kategori');
    }

    /** @test */
    public function product_creation_validates_image_size()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.produk.store'), [
                'nama' => 'Origami Test',
                'kategori' => 'Dekorasi',
                'harga' => 50000,
                'deskripsi' => 'Test deskripsi',
                'gambar' => UploadedFile::fake()->image('large.jpg', 2000, 2000)->size(3000)
            ]);

        $response->assertSessionHasErrors('gambar');
    }
} 