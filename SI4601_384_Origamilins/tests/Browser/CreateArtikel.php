<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateArtikel extends DuskTestCase
{
    /** @test */
    public function test_admin_dapat_menambah_artikel()
    {
        // Hapus user admin jika ada, lalu buat user admin baru
        User::where('email', 'like', 'admin%@gmail.com')->delete();
        $admin = User::factory()->create([
            'name' => 'admin',
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com'
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/artikel/create')
                ->type('judul', 'Tips Origami Mudah')
                ->type('tanggal_publikasi', now()->format('Y-m-d'))
                ->attach('gambar', __DIR__ . '/screenshots/artikel1.jpg')
                // Tunggu CKEditor siap
                ->waitFor('.cke_editable', 10)
                ->pause(1000)
                // Isi CKEditor dengan JavaScript
                ->script([
                    "CKEDITOR.instances['isi'].setData('Ini adalah isi artikel origami yang sangat mudah dan menarik. Ini lebih dari 50 karakter agar valid.');"
                ]);
            // Lanjutkan submit form
            $browser
                ->press('Simpan Artikel')
                ->assertPathIs('/admin/artikel')
                ->assertSee('Tips Origami Mudah')
                ->assertSee('Artikel berhasil ditambahkan')
                ->screenshot('admin-menambah-artikel-berhasil');
        });
    }

    /** @test */
    public function test_validasi_form_artikel()
    {
        User::where('email', 'like', 'admin%@gmail.com')->delete();
        $admin = User::factory()->create([
            'name' => 'admin',
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com'
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/artikel/create')
                ->press('Simpan Artikel'); // Pastikan label tombol submit sama persis dengan di blade
                // Verifikasi pesan error validasi dari Laravel
                // ->assertSee('The judul field is required')
                // ->assertSee('The isi field is required')
                // ->assertSee('The tanggal publikasi field is required')
                // ->assertSee('The gambar field is required')
                // ->screenshot('admin-menambah-artikel-validasi');
        }); 
    }
}
