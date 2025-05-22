<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;

class RegisterTest extends DuskTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    // public function test_user_can_register()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/register')
    //                 ->type('name', 'Fauzan5')
    //                 ->type('email', 'fauzan5@example.com')
    //                 ->type('password', 'password')
    //                 ->type('password_confirmation', 'password')
    //                 ->press('Daftar')
    //                 ->assertSee('Dashboard'); 
    //     });
    // }

    public function testlinkmasuk()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->visit('/register')
                    ->clickLink('Masuk') 
                    ->visit('/login')
                    ->assertSee('Masuk');
        });
    }
}
