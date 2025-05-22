<x-guest-layout>
    <div class="flex flex-row min-h-screen">
        {{-- Bagian kiri opsional jika ada background image --}}
        {{-- <div class="hidden md:block md:w-1/2">
            <img src="{{ asset('storage/Rectangle 4.png') }}" class="w-full h-full object-cover" alt="Background Image">
        </div> --}}
        
        {{-- Bagian kanan dengan form reset password --}}
        <div class="w-full flex items-center justify-center px-6">
            <div class="w-full max-w-md py-12 px-6 bg-white shadow-md rounded-lg">
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Lupa Password</h1>
                    <p class="text-gray-500 mt-2">Masukkan email yang terdaftar dan password baru Anda.</p>
                </div>

{{--                <x-auth-session-status class="mb-4" :status="session('status')" />--}}{{-- Dihapus sementara --}}

                <form method="POST" action="{{ route('reset.password') }}">
                    @csrf

                    {{-- Email Address --}}
                    <div class="mb-4">
{{--                        <x-input-label for="email" value="Email" />--}}{{-- Diganti dengan label HTML --}}
                        <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
{{--                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />--}}{{-- Diganti dengan input HTML --}}
                        <input id="email" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
{{--                        <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}{{-- Error handling manual --}}
                        @error('email')
                            <p class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Baru --}}
                    <div class="mb-4">
{{--                        <x-input-label for="password" value="Password Baru" />--}}{{-- Diganti dengan label HTML --}}
                        <label for="password" class="block font-medium text-sm text-gray-700">Password Baru</label>
{{--                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />--}}{{-- Diganti dengan input HTML --}}
                        <input id="password" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password" />
{{--                        <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}{{-- Error handling manual --}}
                         @error('password')
                            <p class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-4">
{{--                        <x-input-label for="password_confirmation" value="Konfirmasi Password" />--}}{{-- Diganti dengan label HTML --}}
                         <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
{{--                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />--}}{{-- Diganti dengan input HTML --}}
                         <input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
{{--                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />--}}{{-- Error handling manual --}}
                         @error('password_confirmation')
                            <p class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col items-center justify-end mt-4">
                        {{-- Tombol Ubah Password (Hijau) --}}
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Ubah Password
                        </button>
                        
                        {{-- Tombol Kembali Ke Halaman Login (Biru) --}}
                        <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center mt-4 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Kembali Ke Halaman Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
