<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Artikel;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Test;

class ArtikelTest extends DuskTestCase
{
    use DatabaseMigrations;

    #[Test]
    public function test_admin_can_create_artikel()
    {
        $admin = User::factory()->admin()->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/artikel/create')
                ->assertSee('Tambah Artikel')
                ->type('judul', 'Tips Membuat Origami yang Menarik')
                ->type('isi', 'Origami adalah seni melipat kertas yang berasal dari Jepang. Dalam artikel ini, kita akan membahas beberapa tips dasar untuk membuat origami yang menarik dan berkualitas.')
                ->type('tanggal_publikasi', '2024-04-30')
                ->attach('gambar', __DIR__ . '/screenshots/artikel1.jpg')
                ->press('Simpan Artikel')
                ->waitForLocation('/admin/artikel', 10)
                ->assertSee('Artikel berhasil ditambahkan!')
                ->screenshot('admin-create-artikel');
        });
    }

    #[Test]
    public function test_admin_can_view_artikel_details()
    {
        $admin = User::factory()->admin()->create();
        $artikel = Artikel::factory()->create([
            'judul' => 'Origami Festival',
            'isi' => 'Origami adalah seni melipat kertas.',
            'tanggal_publikasi' => now()->addDays(10),
            'gambar' => 'uploads/artikel/test-poster.jpg',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $artikel) {
            $browser->loginAs($admin)
                ->visit("/admin/artikel/{$artikel->id_artikel}")
                ->screenshot('debug')
                ->assertSee('Detail Artikel')
                ->assertSee($artikel->judul)
                ->assertSee($artikel->isi)
                ->assertPresent('img[alt="Gambar Artikel ' . $artikel->judul . '"]')
                ->screenshot('admin-view-artikel');
        });
    }

    #[Test]
    public function test_admin_can_edit_artikel()
    {
        $admin = User::factory()->admin()->create();
        $artikel = Artikel::factory()->create([
            'judul' => 'Origami Festival',
            'isi' => 'Artikel ini akan membahas secara mendalam tentang seni origami.',
            'tanggal_publikasi' => now()->subDays(5),
            'gambar' => 'uploads/artikel/test-poster.jpg',
        ]);
    
        $this->browse(function (Browser $browser) use ($admin, $artikel) {
            $browser->loginAs($admin)
                   ->visit("/admin/artikel/{$artikel->id_artikel}/edit")
                   ->assertSee('Edit Artikel')
                   ->assertInputValue('judul', $artikel->judul)
                   ->assertInputValue('isi', $artikel->isi)
                   ->assertInputValue('tanggal_publikasi', $artikel->tanggal_publikasi->format('Y-m-d'))
                   ->type('judul', 'Berikut Panduan Lengkap Origami: ' . $artikel->judul)
                   ->type('isi', 'Artikel ini akan membahas secara mendalam tentang seni origami.')
                   ->press('Simpan Perubahan')
                   ->waitForLocation('/admin/artikel', 30) // Tunggu hingga 30 detik
                   ->assertSee('Artikel berhasil diperbarui!')
                   ->assertSee('Panduan Lengkap Origami')
                   ->screenshot('admin-edit-artikel');
        });
    }}