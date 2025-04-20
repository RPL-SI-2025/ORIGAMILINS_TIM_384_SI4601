<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_users_list()
    {
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get('/admin/users');

        $response->assertStatus(200)
            ->assertViewHas('users');
    }

    public function test_admin_can_toggle_user_status()
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($this->admin)
            ->post("/admin/users/{$user->id}/toggle-status");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Status user berhasil diubah',
                'new_status' => false
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_active' => false
        ]);
    }

    public function test_admin_can_filter_users_by_name()
    {
        $user = User::factory()->create(['name' => 'Test User']);

        $response = $this->actingAs($this->admin)
            ->get('/admin/users?nama=Test');

        $response->assertStatus(200)
            ->assertViewHas('users', function($users) use ($user) {
                return $users->contains($user);
            });
    }

    public function test_admin_can_filter_users_by_email()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->actingAs($this->admin)
            ->get('/admin/users?email=test@example.com');

        $response->assertStatus(200)
            ->assertViewHas('users', function($users) use ($user) {
                return $users->contains($user);
            });
    }

    public function test_admin_can_filter_users_by_status()
    {
        $activeUser = User::factory()->create(['is_active' => true]);
        $inactiveUser = User::factory()->create(['is_active' => false]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/users?status=1');

        $response->assertStatus(200)
            ->assertViewHas('users', function($users) use ($activeUser, $inactiveUser) {
                return $users->contains($activeUser) && !$users->contains($inactiveUser);
            });
    }

    public function test_admin_can_create_user()
    {
        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'role' => 'user',
            'status' => 'active'
        ];

        $response = $this->actingAs($this->admin)
            ->post('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'role' => $userData['role'],
                'status' => $userData['status']
            ]);

        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_admin_can_update_user()
    {
        $user = User::factory()->create();
        $updateData = [
            'name' => 'Updated Name',
            'role' => 'moderator',
            'status' => 'inactive'
        ];

        $response = $this->actingAs($this->admin)
            ->put("/api/users/{$user->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson($updateData);

        $this->assertDatabaseHas('users', $updateData);
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete("/api/users/{$user->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_can_view_single_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status
            ]);
    }

    public function test_cannot_create_user_with_invalid_data()
    {
        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'role' => 'invalid-role'
        ];

        $response = $this->actingAs($this->admin)
            ->post('/api/users', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password', 'role']);
    }

    public function test_regular_user_cannot_access_user_management()
    {
        $regularUser = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($regularUser)
            ->get('/admin/users');

        $response->assertStatus(403);
    }
} 