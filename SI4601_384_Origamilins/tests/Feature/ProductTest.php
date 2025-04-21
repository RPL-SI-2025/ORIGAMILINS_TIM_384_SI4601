<?php

namespace Tests\Feature;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'admin']);
    }

    public function test_can_view_products_list()
    {
        Produk::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->get('/admin/produk');

        $response->assertStatus(200)
            ->assertViewHas('products');
    }

    public function test_can_create_product()
    {
        $productData = [
            'nama' => 'Test Product',
            'deskripsi' => 'Test Description',
            'harga' => '100000',
            'kategori' => 'Dekorasi',
            'gambar' => null
        ];

        $response = $this->actingAs($this->user)
            ->post('/admin/produk', $productData);

        $response->assertStatus(302)
            ->assertRedirect('/admin/produk');

        $this->assertDatabaseHas('produk', [
            'nama' => $productData['nama'],
            'deskripsi' => $productData['deskripsi'],
            'kategori' => $productData['kategori']
        ]);
    }

    public function test_can_update_product()
    {
        $product = Produk::factory()->create();
        $updateData = [
            'nama' => 'Updated Product',
            'harga' => '150000',
            'kategori' => 'Aksesoris'
        ];

        $response = $this->actingAs($this->user)
            ->put("/admin/produk/{$product->id}", $updateData);

        $response->assertStatus(302)
            ->assertRedirect('/admin/produk');

        $this->assertDatabaseHas('produk', $updateData);
    }

    public function test_can_delete_product()
    {
        $product = Produk::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete("/admin/produk/{$product->id}");

        $response->assertStatus(302)
            ->assertRedirect('/admin/produk');

        $this->assertDatabaseMissing('produk', ['id' => $product->id]);
    }

    public function test_can_view_single_product()
    {
        $product = Produk::factory()->create();

        $response = $this->actingAs($this->user)
            ->get("/admin/produk/{$product->id}/edit");

        $response->assertStatus(200)
            ->assertViewHas('product');
    }

    public function test_cannot_create_product_with_invalid_data()
    {
        $invalidData = [
            'nama' => '',
            'harga' => '-10000',
            'kategori' => ''
        ];

        $response = $this->actingAs($this->user)
            ->post('/admin/produk', $invalidData);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['nama', 'harga', 'kategori']);
    }
} 