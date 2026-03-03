<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ config('app.url') }}">

    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name', 'TOAI HRM Suite') }}
        @else
            {{ config('app.name', 'TOAI HRM Suite') }}
        @endif
    </title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Theme Initialization Script (Prevents Theme Flicker) -->
    <script>
        // Set theme immediately before page renders to prevent flicker
        (function() {
            const storedTheme = localStorage.getItem('hr-theme');
            const theme = storedTheme || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">
    @yield('body')

    {{-- Global portal container for profile dropdown and other overlays --}}
    <div id="hr-dropdown-portal"></div>

    @stack('scripts')
</body>
</html>


