<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Database\Seeders\UserSeeder;
use App\Models\User;


class LoginTest extends DuskTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    public function test_user_can_login()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin' . uniqid() . '@gmail.com',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                    ->type('email', $admin->email)
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->assertPathIs('/admin')
                    ->assertSee('Dashboard')
                    ->screenshot('lg-1'); // sesuaikan dengan konten halaman setelah login
        });
    }

    public function testlinkdaftar()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->visit('/login')
                    ->clickLink('Create one') 
                    ->visit('/register')
                    ->assertSee('Daftar');
        });
    }

}
