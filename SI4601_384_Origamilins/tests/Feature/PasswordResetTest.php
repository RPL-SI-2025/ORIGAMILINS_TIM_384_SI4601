<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that the password reset link request screen can be rendered.
     */
    public function test_password_reset_link_screen_can_be_rendered(): void
    {
        // Menggunakan route name standar Laravel jika ada, fallback ke URL
        $url = $this->routeExists('password.request') ? route('password.request') : '/forgot-password';
        $response = $this->get($url);

        $response->assertStatus(200);
    }

    /**
     * Test that a password reset link can be requested.
     */
    public function test_password_reset_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        // Menggunakan route name standar Laravel jika ada, fallback ke URL
        $url = $this->routeExists('password.email') ? route('password.email') : '/forgot-password';
        $response = $this->post($url, [
            'email' => $user->email,
        ]);

        // Memeriksa redirect atau status 200 tergantung implementasi standar Laravel/Fortify
        // Jika menggunakan route('password.email'), biasanya redirect dengan session status.
        $response->assertSessionHas('status', trans(Password::RESET_LINK_SENT));
        // Jika tidak ada session status atau redirect, Anda mungkin perlu menyesuaikan ini.
        // $response->assertStatus(200) atau $response->assertRedirect(...)

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * Test that the password reset screen can be rendered with a valid token.
     */
    public function test_password_reset_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        // Menggunakan route name standar Laravel jika ada, fallback ke URL
        $requestUrl = $this->routeExists('password.email') ? route('password.email') : '/forgot-password';
        $this->post($requestUrl, [
            'email' => $user->email,
        ]);

        // Get the notification and the token
        $token = null;
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$token) {
            $token = $notification->token;
            return true;
        });

        // Menggunakan route name standar Laravel jika ada, fallback ke URL
        $resetUrl = $this->routeExists('password.reset') ? route('password.reset', ['token' => $token, 'email' => $user->email]) : '/reset-password/' . $token . '?email=' . $user->email;
        $response = $this->get($resetUrl);

        $response->assertStatus(200);
        // Sesuaikan string ini jika teks di view Anda berbeda.
        $response->assertSee('Ubah Password');
    }

    /**
     * Test the complete password reset flow with valid data.
     */
    public function test_password_can_be_reset_and_user_can_login_with_new_password(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $oldPassword = 'oldpassword123';
        $user->password = Hash::make($oldPassword);
        $user->save();

        // 1. Request password reset link
        // Menggunakan route name standar Laravel jika ada, fallback ke URL
        $requestUrl = $this->routeExists('password.email') ? route('password.email') : '/forgot-password';
        $this->post($requestUrl, [
            'email' => $user->email,
        ]);

        // Get the token from the sent notification
        $resetNotification = null;
        $token = null;
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$resetNotification, &$token) {
            $resetNotification = $notification;
            $token = $notification->token;
            return true;
        });

        $newPassword = 'NewSecurePassword123!';

        // 2. Submit the password reset form
        // Menggunakan route name standar Laravel jika ada, fallback ke URL
        $updateUrl = $this->routeExists('password.update') ? route('password.update') : '/reset-password';
        $response = $this->post($updateUrl, [
            'token' => $token,
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // 3. Assert password reset was successful
        // Biasanya redirect ke route login dengan session status atau langsung ke home/dashboard setelah login otomatis.
        $response->assertSessionHas('status', 'Password berhasil direset! Silakan login dengan password baru.');
        // Sesuaikan redirect URL ini dengan halaman setelah reset password berhasil (misalnya '/login' atau '/dashboard').
        // Jika redirect ke halaman lain, ganti '/home' dengan URL tersebut.
        // Jika setelah reset otomatis login, assertAuthenticatedAs($user) akan cukup.
        $response->assertRedirect('/login');

        // Refresh the user model to get the updated password
        $user->refresh();

        // Assert the new password is set correctly (by attempting to log in)
        $this->assertTrue(Hash::check($newPassword, $user->password), 'Password was not updated.');

        // 4. Test login with the new password
        // Menggunakan route name standar Laravel jika ada, fallback ke URL
        $loginUrl = $this->routeExists('login') ? route('login') : '/login';
        $loginResponse = $this->post($loginUrl, [
            'email' => $user->email,
            'password' => $newPassword,
        ]);

        // Sesuaikan redirect URL ini dengan halaman setelah login berhasil.
        // Jika redirect ke halaman lain, ganti '/home' dengan URL tersebut.
        $loginResponse->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    // Helper function to check if a route exists
    protected function routeExists(string $name): bool
    {
        return (bool) \Illuminate\Support\Facades\Route::getRoutes()->getByName($name);
    }

    // Anda dapat menambahkan lebih banyak kasus uji di sini untuk skenario tidak valid:
    // - token tidak valid
    // - password tidak cocok
    // - kegagalan validasi password (terlalu pendek, dll.)
    // - email tidak ditemukan
    // - permintaan dibatasi (throttled)
}
