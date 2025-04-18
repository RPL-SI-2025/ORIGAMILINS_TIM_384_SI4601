<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md relative">
            <h2 class="text-xl font-semibold text-center mb-6">Profil Pengguna</h2>

            <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Foto Profil -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Photo Profil</label>
                    <input type="file" name="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0 file:text-sm file:font-semibold
                        file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    <small class="text-gray-500 text-sm mt-1">Ukuran Max: 512 Kb, Tipe: png, jpg, jpeg</small>
                </div>

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 bg-blue-50" required>
                </div>

                <!-- Nama Panggilan -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" class="w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 bg-blue-50" required>
                </div>

                <!-- Nomor Handphone -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nomor Handphone</label>
                    <input type="text" name="no_hp" class="w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 bg-blue-50" required>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block font-medium mb-1">Email</label>
                    <input type="email" name="email" class="w-full bg-gray-100 border border-gray-300 rounded-lg shadow-sm px-3 py-2" value="{{ auth()->user()->email }}" readonly>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end items-center gap-4 mt-6">
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                    <button type="submit" style="background-color: black; color: white; padding: 8px 16px; border-radius: 6px;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
