<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserProfile;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            $profile = new UserProfile();
            $profile->user_id = $user->id;
            $profile->nama_lengkap = $user->name;
            $profile->nama_panggilan = explode(' ', $user->name)[0]; // Mengambil kata pertama dari nama lengkap
            $profile->email = $user->email;
            $profile->no_hp = '-';
            $profile->save();
        }

        return view('profilpengguna', [
            'user' => $profile
        ]);
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $profile = UserProfile::where('user_id', $user->id)->first();
            
            if (!$profile) {
                $profile = new UserProfile();
                $profile->user_id = $user->id;
            }
            
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'nickname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('user_profiles')->ignore($profile->id)
                ],
                'profile_photo' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg',
                    'max:512'
                ],
            ], [
                'phone.regex' => 'Format nomor telepon tidak valid',
                'phone.min' => 'Nomor telepon minimal 10 digit',
                'email.unique' => 'Email sudah digunakan',
                'profile_photo.max' => 'Ukuran foto profil maksimal 512KB',
                'profile_photo.mimes' => 'Format foto harus jpeg, png, atau jpg'
            ]);

            if ($request->hasFile('profile_photo')) {
                if ($profile->foto && Storage::disk('public')->exists($profile->foto)) {
                    Storage::disk('public')->delete($profile->foto);
                }

                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $profile->foto = $path;
            }

            $profile->nama_lengkap = $request->name;
            $profile->nama_panggilan = $request->nickname;
            $profile->no_hp = $request->phone;
            $profile->email = $request->email;
            $profile->save();

            return redirect()
                ->route('profilpengguna')
                ->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
        }
    }
}
