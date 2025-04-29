<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilPenggunaController extends Controller
{
    public function index()
    {
        return view('profilpengguna.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:512'
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->nickname = $request->nickname;
        $user->phone = $request->phone;

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::delete($user->profile_photo_path);
            }
            $path = $request->file('photo')->store('profile-photos');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return redirect()->route('profilpengguna.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}