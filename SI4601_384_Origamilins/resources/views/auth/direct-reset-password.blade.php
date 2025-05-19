@extends('layouts.guest')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-2 text-center">Lupa Password</h2>
        <p class="text-gray-600 text-center mb-6">
            Masukkan email yang terdaftar dan password baru Anda.
        </p>

        @if (session('success'))
            <div class="mb-4 text-green-600 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-red-600 text-center">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.direct.reset') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input id="email" type="email" name="email" placeholder="Masukkan email anda" class="w-full px-4 py-2 border rounded" required autofocus value="{{ old('email') }}">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-1">Password Baru</label>
                <input id="password" type="password" name="password" placeholder="Masukkan Password Baru" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Konfirmasi password" class="w-full px-4 py-2 border rounded" required>
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded mb-3 transition">
                Ubah Password
            </button>
        </form>

        <a href="{{ route('login') }}" class="w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded transition">
            &larr; Kembali Ke Halaman Login
        </a>
    </div>
</div>
@endsection
