<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    
    public function create()
    {
        $user = Auth::user();
        return view('profilpengguna.create', compact('user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email',
            'foto' => 'nullable|image|max:512|mimes:jpg,jpeg,png',
        ]);

        $userId = Auth::id();

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('profile_photos', 'public');
        }

        UserProfile::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'foto' => $path,
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Profil berhasil disimpan!');
    }
}
