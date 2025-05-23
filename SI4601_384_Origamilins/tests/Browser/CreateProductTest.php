<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Database\Seeders\UserSeeder;

class CreateProductTest extends DuskTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /**
     * Test the product creation form loads correctly
     */
    public function testProductCreatePageLoads()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);
    }

    public function testProductFormValidation()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
            ->type('email', 'admin@gmail.com')
            ->type('password', 'password')
            ->press('Masuk')
            
            ->pause(1000)
            
            ->visit('/admin/produk/create')
            ->assertSee('Tambah Produk Baru')

            ->press('Simpan Produk')
            ->pause(1000)
            ->assertSee('The nama field is required.')
            ->assertSee('The kategori field is required.')
            ->assertSee('The harga dasar field is required.')
            ->assertSee('The deskripsi field is required.')
            ->screenshot('create-test4');
        });
        
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                    ->visit('/admin/produk/create')
                    ->assertSee('Tambah Produk Baru')

                    ->select('kategori', 'Dekorasi') // sesuaikan dengan value kategori yang ada
                    ->type('harga_dasar', '150000')
                    ->check('input[name="ukuran[]"][value="1 meter"]')
                    ->attach('gambar', storage_path('app/public/origami Gajah.jpg')) // siapkan file test-image.jpg
                    ->type('deskripsi', 'Ini adalah produk contoh untuk pengujian')
                    ->press('Simpan Produk')
                    ->pause(1000)
                    ->assertSee('The nama field is required.')
                    ->screenshot('create-test8');
        });

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                    ->visit('/admin/produk/create')
                    ->assertSee('Tambah Produk Baru')

                    ->type('nama', 'Origami gajah')
                    // ->attach('gambar', storage_path('app/public/origami Gajah.jpg')) // siapkan file test-image.jpg
                    ->select('kategori', 'Dekorasi') // sesuaikan dengan value kategori yang ada
                    ->type('harga_dasar', '150000')
                    ->check('input[name="ukuran[]"][value="1 meter"]')
                    ->press('Simpan Produk')
                    ->pause(1000)
                    ->assertSee('The deskripsi field is required.')
                    ->screenshot('create-test9');
        });
        
        
    }

    public function testProductFormValidInput()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                    ->visit('/admin/produk/create')
                    ->assertSee('Tambah Produk Baru')
                    ->type('nama', 'Origami gajah')
                    ->select('kategori', 'Dekorasi') // sesuaikan dengan value kategori yang ada
                    ->type('harga_dasar', '150000')
                    ->check('input[name="ukuran[]"][value="1 meter"]')
                    ->attach('gambar', storage_path('app/public/origami Gajah.jpg')) // siapkan file test-image.jpg
                    ->type('deskripsi', 'Ini adalah produk contoh untuk pengujian')
                    ->press('Simpan Produk')
                    ->pause(1000)
                    ->screenshot('create-test6');
        });

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                    ->visit('/admin/produk/create')
                    ->assertSee('Tambah Produk Baru')
                    ->type('nama', 'Origami gajah kecil')
                    ->select('kategori', 'Merchandise') // sesuaikan dengan value kategori yang ada
                    ->type('harga_dasar', '15000')
                    ->check('input[name="ukuran[]"][value="5 x 5 cm"]')
                    ->check('input[name="ukuran[]"][value="10 x 10 cm"]')
                    ->attach('gambar', storage_path('app/public/origami Gajah.jpg')) // siapkan file test-image.jpg
                    ->type('deskripsi', 'Ini adalah produk contoh untuk pengujian')
                    ->press('Simpan Produk')
                    ->pause(1000)
                    ->screenshot('create-test7');
        });
    }

}
