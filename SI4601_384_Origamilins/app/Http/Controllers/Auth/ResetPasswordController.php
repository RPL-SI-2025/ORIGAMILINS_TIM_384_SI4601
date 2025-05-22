<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User; // Pastikan model User sudah ada
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.reset-password');
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-zA-Z]/', // huruf
                'regex:/[0-9]/',    // angka
                'regex:/[^a-zA-Z0-9]/' // karakter khusus
            ],
        ], [
            'email.exists' => 'Email tidak terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf, angka, dan karakter khusus.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Simpan log reset password (opsional)
        Log::info('Password direset untuk email: '.$user->email.' pada '.now());

        return redirect()->route('login')->with('status', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
