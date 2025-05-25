<?php

namespace Tests\Feature;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAddProdukToCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_add_produk_to_cart_if_not_logged_in()
    {
        // Buat produk dummy
        $produk = Produk::factory()->create(['nama' => 'Produk Test', 'harga' => 10000, 'stok' => 10]);
        // Coba akses endpoint (misal: POST /cart/add) tanpa login
        $response = $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 1]);
        // Harusnya mendapat 401 atau redirect (karena belum login)
        $response->assertStatus(401);
    }

    public function test_user_can_add_produk_to_cart_if_logged_in()
    {
        // Buat user dan produk dummy
        $user = User::factory()->create();
        $produk = Produk::factory()->create(['nama' => 'Produk Test', 'harga' => 10000, 'stok' => 10]);
        // Login sebagai user
        $this->actingAs($user);
        // Kirim request POST ke endpoint (misal: /cart/add) dengan produk_id dan jumlah
        $response = $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 1]);
        // Harusnya mendapat 200 (OK) dan notifikasi sukses
        $response->assertStatus(200)->assertJson(['message' => 'Produk berhasil ditambahkan ke keranjang']);
    }

    public function test_user_can_add_produk_to_cart_when_cart_is_empty()
    {
        // Buat user dan produk dummy
        $user = User::factory()->create();
        $produk = Produk::factory()->create(['nama' => 'Produk Test', 'harga' => 10000, 'stok' => 10]);
        // Login sebagai user
        $this->actingAs($user);
        // Kirim request POST ke endpoint (misal: /cart/add) dengan produk_id dan jumlah
        $response = $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 1]);
        // Harusnya mendapat 200 (OK) dan notifikasi sukses
        $response->assertStatus(200)->assertJson(['message' => 'Produk berhasil ditambahkan ke keranjang']);
    }

    public function test_user_can_update_quantity_if_produk_already_in_cart()
    {
        // Buat user dan produk dummy
        $user = User::factory()->create();
        $produk = Produk::factory()->create(['nama' => 'Produk Test', 'harga' => 10000, 'stok' => 10]);
        // Login sebagai user
        $this->actingAs($user);
        // Tambahkan produk ke keranjang (misal: POST /cart/add) dengan jumlah 1
        $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 1]);
        // Tambahkan lagi produk yang sama (misal: POST /cart/add) dengan jumlah 2
        $response = $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 2]);
        // Harusnya mendapat 200 (OK) dan notifikasi bahwa jumlah diperbarui (misal: "Produk berhasil ditambahkan (jumlah diperbarui)")
        $response->assertStatus(200)->assertJson(['message' => 'Produk berhasil ditambahkan (jumlah diperbarui)']);
    }

    public function test_user_opens_cart_page_when_cart_is_empty()
    {
        // Buat user dummy
        $user = User::factory()->create();
        // Login sebagai user
        $this->actingAs($user);
        // Akses halaman keranjang (misal: GET /cart)
        $response = $this->get('/cart');
        // Harusnya mendapat 200 (OK) dan menampilkan pesan "Keranjang Anda masih kosong"
        $response->assertStatus(200)->assertSee('Keranjang Anda masih kosong');
    }

    public function test_user_opens_cart_page_and_views_produk_in_cart()
    {
        // Buat user dan produk dummy
        $user = User::factory()->create();
        $produk = Produk::factory()->create(['nama' => 'Produk Test', 'harga' => 10000, 'stok' => 10]);
        // Login sebagai user
        $this->actingAs($user);
        // Tambahkan produk ke keranjang (misal: POST /cart/add) dengan jumlah 1
        $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 1]);
        // Akses halaman keranjang (misal: GET /cart)
        $response = $this->get('/cart');
        // Harusnya mendapat 200 (OK) dan menampilkan nama produk (misal: "Produk Test")
        $response->assertStatus(200)->assertSee('Produk Test');
    }

    public function test_user_can_update_quantity_in_cart()
    {
        // Buat user dan produk dummy
        $user = User::factory()->create();
        $produk = Produk::factory()->create(['nama' => 'Produk Test', 'harga' => 10000, 'stok' => 10]);
        // Login sebagai user
        $this->actingAs($user);
        // Tambahkan produk ke keranjang (misal: POST /cart/add) dengan jumlah 1
        $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 1]);
        // Update jumlah produk (misal: POST /cart/update) dengan jumlah baru (misal: 2)
        $response = $this->postJson('/cart/update', ['produk_id' => $produk->id, 'jumlah' => 2]);
        // Harusnya mendapat 200 (OK) dan notifikasi "Jumlah produk berhasil diperbarui"
        $response->assertStatus(200)->assertJson(['message' => 'Jumlah produk berhasil diperbarui']);
    }

    public function test_user_can_remove_produk_from_cart()
    {
        // Buat user dan produk dummy
        $user = User::factory()->create();
        $produk = Produk::factory()->create(['nama' => 'Produk Test', 'harga' => 10000, 'stok' => 10]);
        // Login sebagai user
        $this->actingAs($user);
        // Tambahkan produk ke keranjang (misal: POST /cart/add) dengan jumlah 1
        $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 1]);
        // Hapus produk dari keranjang (misal: POST /cart/remove) dengan produk_id
        $response = $this->postJson('/cart/remove', ['produk_id' => $produk->id]);
        // Harusnya mendapat 200 (OK) dan notifikasi "Produk berhasil dihapus dari keranjang"
        $response->assertStatus(200)->assertJson(['message' => 'Produk berhasil dihapus dari keranjang']);
    }

    public function test_user_can_update_cart_total_price()
    {
        // Buat user dan produk dummy
        $user = User::factory()->create();
        $produk = Produk::factory()->create(['nama' => 'Produk Test', 'harga' => 10000, 'stok' => 10]);
        // Login sebagai user
        $this->actingAs($user);
        // Tambahkan produk ke keranjang (misal: POST /cart/add) dengan jumlah 1
        $this->postJson('/cart/add', ['produk_id' => $produk->id, 'jumlah' => 1]);
        // Update jumlah produk (misal: POST /cart/update) dengan jumlah baru (misal: 2)
        $this->postJson('/cart/update', ['produk_id' => $produk->id, 'jumlah' => 2]);
        // Akses halaman keranjang (misal: GET /cart)
        $response = $this->get('/cart');
        // Harusnya mendapat 200 (OK) dan menampilkan total harga (misal: "Total: Rp 20000")
        $response->assertStatus(200)->assertSee('Total: Rp 20000');
    }

} 