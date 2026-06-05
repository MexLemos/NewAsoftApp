<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background-color: #f8fafc;">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">
            
            <!-- Background element for aesthetics -->
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-[#0f172a] to-[#1e293b]"></div>
            <div class="absolute inset-0 z-0 opacity-10" style="background-image: url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center;"></div>

            <div class="z-10 text-center mb-8">
                <a href="/" class="flex flex-col items-center justify-center text-white no-underline">
                    <!-- Custom Logo instead of Laravel's -->
                    <div class="w-16 h-16 bg-white rounded-xl shadow-lg flex items-center justify-center mb-3">
                        <svg class="w-10 h-10 text-[#0f172a]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-wider">ASOFT<span class="text-yellow-400">MEDIA</span></span>
                </a>
            </div>

            <div class="z-10 w-full sm:max-w-md mt-2 px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-100">
                {{ $slot }}
            </div>
            
            <div class="z-10 mt-8 text-sm text-gray-400">
                &copy; {{ date('Y') }} Asoftmedia. Todos os direitos reservados.
            </div>
        </div>
    </body>
</html>
