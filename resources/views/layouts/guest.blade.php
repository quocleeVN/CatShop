<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CatShop')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-orange-50 to-pink-50 min-h-screen flex flex-col">
    <header class="py-6">
        <div class="container mx-auto px-4 text-center">
            <a href="{{ route('home') }}" class="text-3xl font-bold text-orange-500">
                🐱 CatShop
            </a>
        </div>
    </header>
    <main class="flex-grow flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
            @yield('content')
        </div>
    </main>
    <footer class="py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} CatShop. All rights reserved.
    </footer>
</body>
</html>