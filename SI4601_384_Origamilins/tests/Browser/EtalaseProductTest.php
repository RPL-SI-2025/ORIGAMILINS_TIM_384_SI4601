<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EtalaseProductTest extends DuskTestCase
{
    /**
     * 
     * 
     *
     * @return void
     */
    public function testUserCanLoginAndSeeEtalase(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'user@gmail.com')
                    ->type('password', 'password')
                    ->press('Masuk'); 
            $browser->assertPathIs('/etalase-produk');
            $browser->waitForText('Etalase Produk', 10)
                    ->assertSee('Etalase Produk');
        });
    }
}