<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="bg-gray-100 min-h-screen py-8">
        <div class="max-w-6xl mx-auto bg-white shadow rounded-lg flex">
            <!-- Sidebar -->
            <aside class="w-64 border-r bg-gray-50 p-6 hidden md:block">
                <div class="flex flex-col items-center mb-8">
                    <div class="w-20 h-20 rounded-full bg-purple-200 flex items-center justify-center text-4xl font-bold text-white mb-2">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                    <div class="font-semibold">{{ auth()->user()->name }}</div>
                    <a href="#" class="text-xs text-blue-500 hover:underline mt-1">Ubah Profil</a>
                </div>
                <nav class="space-y-2 text-gray-700 text-sm">
                    <div class="font-semibold text-orange-500">Akun Saya</div>
                    <a href="#" class="block px-2 py-1 rounded bg-orange-100 text-orange-700">Profil</a>
                    <a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Alamat</a>
                    <a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Ubah Password</a>
                    <div class="mt-4 font-semibold text-gray-500">Pesanan Saya</div>
                    <a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Riwayat Pesanan</a>
                </nav>
            </aside>
            <!-- Main Content -->
            <main class="flex-1 p-8">
                <h3 class="text-lg font-semibold mb-2">Profil Saya</h3>
                <p class="text-gray-500 mb-6">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Form Profil -->
                    <div class="md:col-span-2">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.update-profile-information-form')
                        @endif

                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.update-password-form')
                            </div>
                        @endif
                    <!-- Avatar & Upload -->
                    <div class="flex flex-col items-center">
                        <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-5xl font-bold text-white overflow-hidden mb-4">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Foto Profil" class="object-cover w-full h-full">
                            @else
                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                            @endif
                        </div>
                        <label class="block font-medium mb-1">Foto Profil</label>
                        <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="photo" class="block w-full text-sm text-gray-500 mb-2">
                            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded font-semibold">Pilih Gambar</button>
                        </form>
                        <small class="text-gray-500 text-sm mt-1">Ukuran maks: 1 MB, Format: .JPEG, .PNG</small>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>