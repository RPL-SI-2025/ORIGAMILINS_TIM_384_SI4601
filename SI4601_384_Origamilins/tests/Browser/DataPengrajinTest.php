<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Pengrajin;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DataPengrajinTest extends DuskTestCase
{
    /** @test */
    public function test_admin_dapat_menambah_pengrajin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('admin.pengrajin.pengrajin.index'))
                ->assertSee('Daftar Pengrajin')
                ->clickLink('Tambah Pengrajin')
                ->assertPathIs('/admin/pengrajin/pengrajin/create')
                ->type('nama', 'Pengrajin Dusk')
                ->type('email', 'pengrajin' . uniqid() . '@mail.com')
                ->select('is_active', '1')
                ->press('Simpan')
                ->screenshot('after-press-simpan-pengrajin')
                ->assertPathIs('/admin/pengrajin/pengrajin')
                ->assertSee('Pengrajin berhasil ditambahkan!')
                ->assertSee('Pengrajin Dusk')
                ->screenshot('pengrajin-tambah-berhasil');
        });
    }

    /** @test */
    public function test_admin_dapat_mengedit_pengrajin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);
        $pengrajin = Pengrajin::create([
            'nama' => 'Pengrajin Lama',
            'email' => 'lama' . uniqid() . '@mail.com',
            'is_active' => 1,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $pengrajin) {
            $browser->loginAs($admin)
                ->visit(route('admin.pengrajin.pengrajin.index'))
                ->assertSee($pengrajin->nama)
                ->click('@edit-pengrajin-' . $pengrajin->id) 
                ->assertPathIs('/admin/pengrajin/pengrajin/' . $pengrajin->id . '/edit')
                ->type('nama', 'Pengrajin Baru')
                ->select('is_active', '0')
                ->press('Update')
                ->waitForLocation('/admin/pengrajin/pengrajin')
                ->assertSee('Pengrajin berhasil diupdate!')
                ->assertSee('Pengrajin Baru')
                ->screenshot('pengrajin-edit-berhasil');
        });
    }

    /** @test */
    public function test_admin_dapat_menghapus_pengrajin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);
        $pengrajin = Pengrajin::create([
            'nama' => 'Pengrajin Hapus',
            'email' => 'hapus' . uniqid() . '@mail.com',
            'is_active' => 1,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $pengrajin) {
            $browser->loginAs($admin)
            ->visit(route('admin.pengrajin.pengrajin.index'))
            ->assertSee($pengrajin->nama)
            ->script('window.confirm = function(){return true;}');
        $browser->click('@hapus-pengrajin-' . $pengrajin->id)
            ->waitForLocation('/admin/pengrajin/pengrajin')
            ->assertSee('Pengrajin berhasil dihapus!')
            ->screenshot('pengrajin-hapus-berhasil');
        });
    }

    /** @test */
    public function test_admin_dapat_filter_pengrajin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);
        Pengrajin::create([
            'nama' => 'Pengrajin Filter',
            'email' => 'filter' . uniqid() . '@mail.com',
            'is_active' => 1,
        ]);
        Pengrajin::create([
            'nama' => 'Pengrajin Tidak Aktif',
            'email' => 'nonaktif' . uniqid() . '@mail.com',
            'is_active' => 0,
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('admin.pengrajin.pengrajin.index'))
                ->type('nama', 'Filter')
                ->press('Cari')
                ->assertSee('Pengrajin Filter')
                ->assertDontSee('Pengrajin Tidak Aktif')
                ->screenshot('pengrajin-filter-berhasil');
        });
    }
}