<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            $profile = new UserProfile();
            $profile->user_id = $user->id;
            $profile->nama_lengkap = $user->name;
            $profile->email = $user->email;
            $profile->save();
        }

        return view('profilpengguna', [
            'user' => $profile
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            $profile = new UserProfile();
            $profile->user_id = $user->id;
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:512'], // max 512KB sesuai view
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($profile->foto) {
                Storage::delete($profile->foto);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos');
            $profile->foto = $path;
        }

        $profile->nama_lengkap = $request->name;
        $profile->nama_panggilan = $request->nickname;
        $profile->no_hp = $request->phone;
        $profile->email = $request->email;
        $profile->save();

        return redirect()->route('profilpengguna')->with('success', 'Profil berhasil diperbarui!');
    }
}
