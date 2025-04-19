<?php

namespace Tests\Feature;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

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
    }

    public function test_admin_can_view_product_list()
    {
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.produk.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.produk.index');
    }

    public function test_admin_can_create_product()
    {
        $this->actingAs($this->admin);
        Storage::fake('public');

        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->post(route('admin.produk.store'), [
            'nama' => 'Test Product',
            'kategori' => 'Test Category',
            'harga' => 100000,
            'gambar' => $file,
            'deskripsi' => 'Test Description'
        ]);

        $response->assertRedirect(route('admin.produk.index'));
        $this->assertDatabaseHas('produks', [
            'nama' => 'Test Product',
            'kategori' => 'Test Category',
            'harga' => 100000,
            'deskripsi' => 'Test Description'
        ]);

        Storage::disk('public')->assertExists('uploads/produk/' . $file->hashName());
    }

    public function test_product_creation_requires_valid_data()
    {
        $this->actingAs($this->admin);
        
        $response = $this->post(route('admin.produk.store'), []);
        
        $response->assertSessionHasErrors(['nama', 'kategori', 'harga', 'gambar', 'deskripsi']);
    }

    public function test_admin_can_edit_product()
    {
        $this->actingAs($this->admin);
        Storage::fake('public');

        $product = Produk::factory()->create();
        $file = UploadedFile::fake()->image('new-product.jpg');

        $response = $this->put(route('admin.produk.update', $product), [
            'nama' => 'Updated Product',
            'kategori' => 'Updated Category',
            'harga' => 200000,
            'gambar' => $file,
            'deskripsi' => 'Updated Description'
        ]);

        $response->assertRedirect(route('admin.produk.index'));
        $this->assertDatabaseHas('produks', [
            'id' => $product->id,
            'nama' => 'Updated Product',
            'kategori' => 'Updated Category',
            'harga' => 200000,
            'deskripsi' => 'Updated Description'
        ]);
    }

    public function test_admin_can_delete_product()
    {
        $this->actingAs($this->admin);
        Storage::fake('public');

        $product = Produk::factory()->create();
        
        $response = $this->delete(route('admin.produk.destroy', $product));
        
        $response->assertRedirect(route('admin.produk.index'));
        $this->assertDatabaseMissing('produks', ['id' => $product->id]);
    }

    public function test_non_admin_cannot_access_product_management()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('admin.produk.index'));
        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_product_management()
    {
        $response = $this->get(route('admin.produk.index'));
        $response->assertRedirect(route('login'));
    }
}