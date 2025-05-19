<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DirectResetPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.direct-reset-password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).+$/',
                'confirmed'
            ],
        ], [
            'email.exists' => 'Email tidak terdaftar.',
            'password.regex' => 'Password minimal 8 karakter, kombinasi huruf, angka, dan 1 karakter khusus.'
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Simpan log jika perlu
        // Log::info('Reset password: '.$user->email);

        return back()->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
