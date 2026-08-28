<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Global Loading Overlay -->
        <div id="global-page-loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.85); z-index: 99999; justify-content: center; align-items: center; flex-direction: column;">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-blue-600"></div>
            <h5 class="mt-4 font-bold text-blue-600 text-lg">Processando...</h5>
        </div>
        
        <script>
            document.addEventListener('submit', function () {
                document.getElementById('global-page-loader').style.display = 'flex';
            });
            document.addEventListener('click', function(e) {
                let target = e.target.closest('a');
                if(target && target.href) {
                    if(target.getAttribute('href').startsWith('javascript:') || target.getAttribute('href') === '#') return;
                    if(target.getAttribute('target') === '_blank') return;
                    if(target.getAttribute('data-bs-toggle') !== null) return;
                    if(target.hasAttribute('download')) return;

                    if (target.hostname === window.location.hostname && 
                        target.pathname === window.location.pathname && 
                        target.search === window.location.search) {
                        return;
                    }

                    document.getElementById('global-page-loader').style.display = 'flex';
                }
            });
            window.addEventListener('pageshow', function() {
                document.getElementById('global-page-loader').style.display = 'none';
            });
        </script>
    </body>
</html>
