<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class FilterNamaTest extends DuskTestCase
{
    #[Test]
    public function user_can_filter_by_name()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('input[name=email]')
                    ->type('email', 'user@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->waitForLocation('/etalase-produk')
                    ->type('input[name=nama]', 'Angsa')
                    ->press('Terapkan')
                    ->pause(1000)
                    ->assertQueryStringHas('nama', 'Angsa');
        });
    }

    #[Test]
    public function user_can_reset_filter_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/etalase-produk')
                    ->clickLink('Reset')
                    ->pause(1000)
                    ->assertInputValue('nama', '')
                    ->assertInputValue('harga_min', '')
                    ->assertInputValue('harga_max', '');
        });
    }

    #[Test]
    public function user_can_filter_by_min_price()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/etalase-produk')
                    ->type('input[name=harga_min]', '20000')
                    ->press('Terapkan')
                    ->pause(1000)
                    ->assertQueryStringHas('harga_min', '20000');
        });
    }
}
