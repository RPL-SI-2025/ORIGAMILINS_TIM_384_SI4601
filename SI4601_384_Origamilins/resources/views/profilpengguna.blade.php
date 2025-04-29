@extends('layouts.guest')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Profil Pengguna</h2>
            
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Photo Profile -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Photo Profil</label>
                    <div class="mt-1 flex items-center space-x-4">
                        <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Pilih File
                        </button>
                        <span class="text-sm text-gray-500">Tidak ada file yang dipilih</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Ukuran Max: 512 Kb, Tipe: png, jpg, jpeg</p>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Nama Panggilan -->
                <div>
                    <label for="nama_panggilan" class="block text-sm font-medium text-gray-700">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" id="nama_panggilan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Nomor Handphone -->
                <div>
                    <label for="nomor_handphone" class="block text-sm font-medium text-gray-700">Nomor Handphone</label>
                    <input type="tel" name="nomor_handphone" id="nomor_handphone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="admin@gmail.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" readonly>
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Simpan Perubahan
                    </button>
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 