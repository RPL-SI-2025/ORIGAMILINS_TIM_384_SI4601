@extends('layouts.guest')

@section('content')
    <div class="flex flex-row min-h-screen">
        <!-- Left side with background image -->
        <div class="hidden md:block md:w-1/2">
            <img src="{{ asset('storage/Rectangle 4.png') }}" class="w-full h-full object-cover" alt="Background Image">
        </div>
        
        <!-- Right side with login form -->
        <div class="w-full md:w-1/2 flex items-center justify-center px-6">
            <div class="w-full max-w-md py-12">
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Masuk</h1>
                    <p class="text-gray-500 mt-2">Silakan masuk untuk melanjutkan akun Anda.</p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="text-red-600">
                            {{ __('Whoops! Something went wrong.') }}
                        </div>

                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input id="email" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg" 
                            type="email" 
                            name="email" 
                            placeholder="Email"
                            :value="old('email')" 
                            required autofocus 
                            autocomplete="username" />
                    </div>

                    <div class="mb-4">
                        <div class="relative">
                            <x-input id="password" 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg" 
                                type="password" 
                                name="password" 
                                placeholder="Kata Sandi"
                                required 
                                autocomplete="current-password" />
                            <button type="button" onclick="togglePasswordVisibility('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 password-toggle-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" class="rounded text-cyan-500" />
                            <span class="ms-2 text-sm text-gray-600">Izinkan tetap masuk</span>
                        </label>
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="w-full bg-cyan-500 text-white font-medium py-3 px-4 rounded-md hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="relative flex items-center justify-center my-6">
                    <div class="absolute w-full border-t border-gray-300"></div>
                    <div class="relative bg-white px-4 text-sm text-gray-500">atau</div>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Need an account? 
                        <a href="{{ route('register') }}" class="text-cyan-500 hover:underline">Create one</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon (optional)
            const icon = document.querySelector(`button[onclick="togglePasswordVisibility('${inputId}')"] svg`);
            if (type === 'text') {
                // Show the "hide password" icon (eye-off)
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                // Show the "show password" icon (eye)
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
@endsection