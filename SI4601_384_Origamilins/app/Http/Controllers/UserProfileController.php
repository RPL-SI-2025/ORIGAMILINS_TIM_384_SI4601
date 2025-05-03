<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserProfile;
use Illuminate\Validation\Rule;
use App\Models\User;

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
            $profile->nama_panggilan = explode(' ', $user->name)[0];
            $profile->email = $user->email;
            $profile->no_hp = '-';
            $profile->save();
        }

        return view('profilpengguna', ['user' => $profile]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('profilpengguna.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|exists:users,email'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('public/profiles');
            $validated['foto'] = str_replace('public/', '', $fotoPath);
        }

        $user = User::where('email', $validated['email'])->first();
        $user->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nama_panggilan' => $validated['nama_panggilan'],
            'no_hp' => $validated['no_hp'],
            'name' => $validated['nama_lengkap'],
            'nickname' => $validated['nama_panggilan'],
            'phone' => $validated['no_hp'],
        ]);

        return redirect()->route('profilpengguna')
            ->with('success', 'Profil berhasil dibuat');
    }

    public function update(Request $request)
    {
        \Log::info('DEBUG: Data masuk ke update', $request->all());
        try {
            \Log::info('Update profile started');
            
            $user = Auth::user();
            $profile = UserProfile::where('user_id', $user->id)->first();
            
            if (!$profile) {
                $profile = new UserProfile();
                $profile->user_id = $user->id;
            }
            
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'nickname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'regex:/^([0-9\\s\\-\\+\\(\\)]*)$/', 'min:10', 'max:20'],
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
                'profile_photo.mimes' => 'Format foto harus jpeg, png, atau jpg',
                'name.required' => 'Nama Lengkap wajib diisi',
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

            \Log::info('Profile updated successfully');
            return redirect()->route('profilpengguna')->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            \Log::error('Error updating profile: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['name' => 'Nama Lengkap wajib diisi']);
        }
    }
}
