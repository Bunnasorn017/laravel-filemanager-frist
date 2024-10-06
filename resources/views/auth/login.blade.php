<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB Files Manage - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('logo.png')}}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center overflow-hidden">
    <video class="fixed right-0 bottom-0 min-w-full min-h-full w-auto h-auto object-cover -z-10" autoplay muted loop>
        <source src="{{ asset('background/mario-pixel-room.3840x2160.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div
        class="bg-white bg-opacity-30 p-8 rounded-lg shadow-2xl w-full max-w-md relative overflow-hidden backdrop-blur-sm">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 opacity-20"></div>
        <div class="relative z-10">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('logo.png') }}" alt="logo" class="w-32 h-32 object-contain">
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">WEB Files Manage</h1>
            <p class="text-white mb-6 text-center">Login to manage your files</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" required autofocus autocomplete="username"
                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                                  focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                                  transition duration-150 ease-in-out">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                                  focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                                  transition duration-150 ease-in-out">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out transform hover:scale-105">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-black">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                        class="font-medium text-white hover:text-black transition duration-150 ease-in-out">
                        Register now
                    </a>
                </p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: "error",
                title: "Something Wrong!",
                text: "Email หรือ Password ไม่ถูกต้อง",
                confirmButtonColor: '#4F46E5',
            });
        </script>
    @endif
</body>

</html>
