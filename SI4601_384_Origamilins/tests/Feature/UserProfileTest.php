<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $admin;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'name' => 'John Doe',
            'role' => 'admin'
        ]);

        // Create regular user
        $this->user = User::factory()->create([
            'role' => 'user'
        ]);
    }

    /** @test */
    public function admin_can_view_profile_index()
    {
        $profile = UserProfile::create([
            'user_id' => $this->admin->id,
            'nama_lengkap' => 'John Doe',
            'nama_panggilan' => 'John',
            'no_hp' => '081234567890',
            'email' => 'john@example.com'
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/profilpengguna');

        $response->assertStatus(200)
            ->assertViewIs('profilpengguna')
            ->assertSee('Profil Pengguna');
    }

    /** @test */
    public function admin_can_create_profile()
    {
        Storage::fake('public');

        $profileData = [
            'name' => 'John Doe',
            'nickname' => 'John',
            'phone' => '081234567890',
            'email' => 'john@example.com',
            'profile_photo' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $response = $this->actingAs($this->admin)
            ->put('/profilpengguna', $profileData);

        $response->assertRedirect('/profilpengguna')
            ->assertSessionHas('success', 'Profil berhasil diperbarui!');

        // Check database
        $this->assertDatabaseHas('user_profiles', [
            'nama_lengkap' => 'John Doe',
            'nama_panggilan' => 'John',
            'no_hp' => '081234567890',
            'email' => 'john@example.com',
        ]);

        // Verify file was stored
        $profile = UserProfile::where('user_id', $this->admin->id)->first();
        Storage::disk('public')->assertExists($profile->foto);
    }

    /** @test */
    public function admin_can_view_profile_detail()
    {
        $profile = UserProfile::create([
            'user_id' => $this->admin->id,
            'nama_lengkap' => 'John Doe',
            'nama_panggilan' => 'John',
            'no_hp' => '081234567890',
            'email' => 'john@example.com'
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/profilpengguna');

        $response->assertStatus(200)
            ->assertViewIs('profilpengguna')
            ->assertSee('John Doe')
            ->assertSee('081234567890');
    }

    /** @test */
    public function admin_can_update_profile()
    {
        $profile = UserProfile::create([
            'user_id' => $this->admin->id,
            'nama_lengkap' => 'John Doe',
            'nama_panggilan' => 'John',
            'no_hp' => '081234567890',
            'email' => 'john@example.com'
        ]);

        $updatedData = [
            'name' => 'Jane Doe',
            'nickname' => 'Jane',
            'phone' => '089876543210',
            'email' => 'jane@example.com'
        ];

        $response = $this->actingAs($this->admin)
            ->put('/profilpengguna', $updatedData);

        $response->assertRedirect('/profilpengguna')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('user_profiles', [
            'nama_lengkap' => 'Jane Doe',
            'nama_panggilan' => 'Jane',
            'no_hp' => '089876543210',
            'email' => 'jane@example.com'
        ]);
    }

    /** @test */
    public function admin_can_delete_profile_photo()
    {
        Storage::fake('public');
        
        $file = UploadedFile::fake()->image('avatar.jpg');
        $path = $file->store('profile-photos', 'public');

        $profile = UserProfile::create([
            'user_id' => $this->admin->id,
            'nama_lengkap' => 'John Doe',
            'nama_panggilan' => 'John',
            'no_hp' => '081234567890',
            'email' => 'john@example.com',
            'foto' => $path
        ]);

        // Update with new photo (should delete old one)
        $response = $this->actingAs($this->admin)
            ->put('/profilpengguna', [
                'name' => 'John Doe',
                'nickname' => 'John',
                'phone' => '081234567890',
                'email' => 'john@example.com',
                'profile_photo' => UploadedFile::fake()->image('new-avatar.jpg')
            ]);

        $response->assertRedirect('/profilpengguna');
        Storage::disk('public')->assertMissing($path);
    }

    /** @test */
    public function guest_cannot_access_profile_management()
    {
        $response = $this->get('/profilpengguna');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function validate_profile_creation()
    {
        $response = $this->actingAs($this->admin)
            ->put('/profilpengguna', [
                'name' => '', // required field left empty
                'nickname' => 'John',
                'phone' => '081234567890',
                'email' => 'invalid-email' // invalid email format
            ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }
} 