<x-guest-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- สถานะการเซสชัน -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <div class="flex justify-center mb-3">
            <img src="{{ asset('logo.png') }}" alt="logo" width="300px" height="300px">
        </div>

        <hr class="border-solid border-1 border-black">

        <h1 class="text-2xl font-bold text-gray-800 mt-4 text-center">WEB Files Manage</h1>
        <p class="text-gray-600 mt-2 text-center">Please log in to manage your files</p>

        <form method="POST" action="{{ route('login') }}" class="bg-white p-8 max-w-md mx-auto">
            @csrf

            <!-- อีเมล -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-800 font-semibold" />
                <x-text-input id="email"
                    class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 transition-transform transform hover:scale-105"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- รหัสผ่าน -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-800 font-semibold" />
                <x-text-input id="password"
                    class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 transition-transform transform hover:scale-105"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- จดจำฉัน -->
            {{-- <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-transform transform hover:scale-105"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-800">{{ __('Remember me') }}</span>
                </label>
            </div> --}}

            <!-- ลืมรหัสผ่านและปุ่มเข้าสู่ระบบ -->
            {{-- <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-indigo-600 hover:text-indigo-800 transition-colors duration-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}

            <div class="flex justify-center mt-4">
                <x-primary-button
                    class="items-center justify-center ms-3 bg-indigo-600 hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:scale-105 mt-3 text-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <!-- Don't have an account? Register -->
            <div class="mt-6 text-center">
                <span class="text-gray-800">Don't have an account?</span>
                <a class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200 underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('register') }}">
                    {{ __('Register!') }}
                </a>
            </div>
        </form>
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Something Worng!",
                    text: "Email หรือ Password ไม่ถูกต้อง",
                });
            </script>
        @endif
    </div>
</x-guest-layout>
