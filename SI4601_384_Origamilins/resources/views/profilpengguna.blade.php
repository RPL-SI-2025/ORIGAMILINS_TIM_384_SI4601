@extends('layouts.guest')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Profil Pengguna</h2>
            
            @if (session('success'))
                <div class="alert alert-success" id="success-message">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('profilpengguna.update', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Photo Profile -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Photo Profil</label>
                    <div class="mt-1 flex items-center space-x-4">
                        <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($user->profile_photo_path)
                                <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <label class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
                            <span>Pilih File</span>
                            <input type="file" name="profile_photo" class="hidden" onchange="updateFileName(this)">
                        </label>
                        <span id="selectedFileName" class="text-sm text-gray-500">Tidak ada file yang dipilih</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Ukuran Max: 512 Kb, Tipe: png, jpg, jpeg</p>
                    @error('profile_photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->nama_lengkap) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600" dusk="error-name">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Panggilan -->
                <div>
                    <label for="nickname" class="block text-sm font-medium text-gray-700">Nama Panggilan</label>
                    <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nama_panggilan) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('nickname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Handphone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Handphone</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->no_hp) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileName = input.files[0]?.name || 'Tidak ada file yang dipilih';
    document.getElementById('selectedFileName').textContent = fileName;
}
</script>
@endsection 