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

    <!-- Styles -->
    @livewireStyles
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Scripts -->
</head>

<body x-data="{
    page: '{{ $pageName ?? 'default' }}',
    loaded: true,
    darkMode: false,
    stickyMenu: false,
    sidebarToggle: false,
    scrollTop: false
}" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }">

    <div>
        <!-- ===== Preloader Start ===== -->
        <x-partials.preloader />
        <!-- ===== Preloader End ===== -->
        <!-- ===== Page Wrapper Start ===== -->
        <div class="flex h-screen overflow-hidden">
            <!-- ===== Sidebar Start ===== -->
            <x-partials.sidebar />
            <!-- ===== Sidebar End ===== -->
            <!-- ===== Content Area Start ===== -->
            <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
                <!-- ===== Small Device Overlay Start ===== -->
                <div @click="sidebarToggle = false" :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
                    class="fixed w-full h-screen z-9 bg-gray-900/50">
                </div>
                <!-- ===== Small Device Overlay End ===== -->
                <!-- ===== Header Start ===== -->
                <x-partials.header />
                <!-- ===== Header End ===== -->
                <!-- ===== Main Content Start ===== -->
                {{ $slot }}
                <!-- ===== Main Content End ===== -->
            </div>
            <!-- ===== Content Area End ===== -->
        </div>
        <!-- ===== Page Wrapper End ===== -->
    </div>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            flatpickr("input[type=date]");
        });
        document.addEventListener('livewire:navigated', () => {
            flatpickr("input[type=date]");
        });
    </script>
</body>
</html>
