<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfilPenggunaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_view_profil_form()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)
            ->get('/profilpengguna');
        
        $response->assertStatus(200)
            ->assertViewIs('profilpengguna')
            ->assertSee('Profil Pengguna');
    }

    public function test_admin_can_create_profil()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($admin)
            ->post('/profilpengguna', [
                'foto' => $file,
                'nama_lengkap' => 'John Doe',
                'nama_panggilan' => 'John',
                'no_hp' => '081234567890',
                'email' => $admin->email
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'email' => $admin->email
        ]);
    }

    public function test_guest_can_access_profil_form()
    {
        $response = $this->get('/profilpengguna');
        
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_validate_profil_creation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)
            ->post('/profilpengguna', [
                'foto' => 'bukan-file',
                'nama_lengkap' => '',
                'nama_panggilan' => '',
                'no_hp' => 'bukan-nomor',
                'email' => ''
            ]);

        $response->assertSessionHasErrors(['foto', 'nama_lengkap', 'nama_panggilan', 'email']);
    }

    public function test_admin_can_update_profil()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'nama_lengkap' => 'Nama Lama',
            'nama_panggilan' => 'Panggilan Lama',
            'no_hp' => '080000000000'
        ]);
        
        $response = $this->actingAs($admin)
            ->put('/profilpengguna/' . $admin->id, [
                'nama_lengkap' => 'Nama Baru',
                'nama_panggilan' => 'Panggilan Baru',
                'no_hp' => '081234567890',
                'email' => $admin->email
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'email' => $admin->email
        ]);
    }

    public function test_user_can_access_profil_after_login()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $response = $this->actingAs($user)
            ->get('/profilpengguna');
        
        $response->assertStatus(200)
            ->assertSee('Profil Pengguna');
    }
} 