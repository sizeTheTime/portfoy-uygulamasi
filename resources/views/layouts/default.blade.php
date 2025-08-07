<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mikrofon Süngeri')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/site.webmanifest') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/laravel.js'])
    @stack('styles')
</head>

<body class="font-outfit bg-white text-[#121010]">
    <x-navbar />
    <x-sidebar />

    <x-mobile-navigation />

    <!-- Mobile Top Header -->
    <div class="md:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100 px-4 py-4 shadow-sm">
        <div class="flex items-center justify-between">
            <button onclick="goBack()"
                class="group flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 active:bg-gray-300 transition-all duration-200 active:scale-95">
                <svg class="w-5 h-5 text-gray-700 group-hover:text-gray-900 transition-colors duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <h1 class="text-lg font-semibold text-gray-900 truncate mx-4 flex-1 text-center">
                @yield('title', 'Mikrofon Süngeri')
            </h1>
            <div class="w-10 h-10"></div>
        </div>
    </div>

    <div class="mt-[90px] ml-0 lg:ml-[90px]">
        @yield('content')
    </div>


    <script>
        function goBack() {
            if ('vibrate' in navigator) navigator.vibrate(30);
            if (window.history.length > 1) window.history.back();
            else window.location.href = '/';
        }
        document.addEventListener('DOMContentLoaded', function() {
            const svgs = document.querySelectorAll('.lg\\:hidden svg');
            let fail = false;
            svgs.forEach(s => {
                if (!s.getBBox || s.getBBox().width === 0) fail = true
            });
            if (fail) {
                document.querySelector('.lg\\:hidden:not(#backup-nav)').style.display = 'none';
                document.getElementById('backup-nav').style.display = 'block';
            }
        });
        if ('vibrate' in navigator) {
            document.querySelectorAll('a[href^="tel:"], a[href*="wa.me"]').forEach(el =>
                el.addEventListener('click', () => navigator.vibrate([50, 30, 50]))
            );
        }
    </script>

    <x-contact-widget />

    @stack('scripts')
</body>

</html>
