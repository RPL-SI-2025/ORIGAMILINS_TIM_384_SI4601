<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FilterKategoriTest extends DuskTestCase
{
    /** @test */
    public function user_can_filter_by_merchandise()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('input[name=email]')
                    ->type('email', 'user@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->waitForLocation('/etalase-produk')
                    ->check('input[type="checkbox"][value="Merchandise"]')
                    ->press('Terapkan')
                    ->pause(1000)
                    ->assertSee('Merchandise');
        });
    }

    /** @test */
    public function user_can_filter_by_dekorasi()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->visit('/login')
                    ->waitFor('input[name=email]')
                    ->type('email', 'user@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->waitForLocation('/etalase-produk')
                    ->check('input[type="checkbox"][value="Dekorasi"]')
                    ->press('Terapkan')
                    ->pause(1000)
                    ->assertSee('Dekorasi');
        });
    }

    /** @test */
    public function user_can_filter_by_semua()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->visit('/login')
                    ->waitFor('input[name=email]')
                    ->type('email', 'user@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->waitForLocation('/etalase-produk')
                    ->check('#checkAllKategori')
                    ->press('Terapkan')
                    ->pause(1000)
                    ->assertPathIs('/etalase-produk');
        });
    }
}
