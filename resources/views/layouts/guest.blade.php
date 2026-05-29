<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Master Data') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100 text-slate-800">
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 p-6">
        <!-- Logo -->
        <div class="mb-8 text-center">
            <a href="/" class="flex flex-col items-center group">
                <div class="bg-white p-3 rounded-xl shadow-sm mb-4 group-hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="h-16 w-16 bg-primary rounded-lg items-center justify-center hidden">
                        <span class="text-white font-bold text-2xl">M</span>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-primary tracking-widest uppercase">{{ config('app.name', 'Master Data') }}</h1>
                <p class="text-2xl text-slate-700 uppercase mt-2 font-medium">PT SARI TAKAGI ELOK PRODUK</p>
            </a>
        </div>

        <!-- Content Card -->
        <div class="w-full sm:max-w-md bg-white shadow-2xl rounded-2xl overflow-hidden border border-slate-100">
            <!-- Decorative Header Line -->
            <div class="h-2 bg-primary w-full"></div>

            <div class="px-8 py-10">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Master Data') }}
            </p>
        </div>
    </div>
</body>

</html>
