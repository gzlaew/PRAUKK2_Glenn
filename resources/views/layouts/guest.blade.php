@php
    use App\Models\settings;
    $setting = settings::first();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :dir="$store.app.direction" x-data="{ direction: $store.app.direction }"
    x-bind:dir="direction" class="group/item" :data-mode="$store.app.mode" :data-sidebar="$store.app.sidebarMode">

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laravel' }} | Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Tailwind CSS Admin & Dashboard Template" name="description">
    <meta content="SRBThemes" name="author">
    <!-- favicon -->
    <link rel="shortcut icon" href="/favicon.ico">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <x-layout.head-css styles="{{ $styles ?? '' }}" />

    <!-- Scripts -->
    @vite(['resources/scss/tailwind.scss'])

    <!-- Styles -->
    @livewireStyles
</head>

<x-layout.body />

<!-- Start Layout -->
<div class="bg-[#f9fbfd] dark:bg-dark min-h-screen relative z-10">

    <!-- Start Background Images -->
    <div
        class="bg-[url('../images/bg-main.png')] bg-black dark:bg-purple min-h-[220px] sm:min-h-[50vh] bg-bottom w-full -z-10 absolute">
    </div>
    <!-- End Background Images -->

    <!-- Start Header -->
    <header>
        <nav class="px-4 lg:px-7 py-4 max-w-[1440px] mx-auto">
            <div class="flex flex-wrap items-center justify-between">

            </div>
        </nav>
    </header>
    <!-- End Header -->

    <div class="flex flex-col items-center justify-center space-y-4 p-4 bg-white-900 text-white rounded-lg shadow-md max-w-md mx-auto mt-6">
        <img src="{{ asset('storage/' . $setting->logo) }}" class="h-12 w-12 object-cover rounded-full" alt="Logo" />
        <h2 class="text-lg font-semibold">{{ $setting->name }}</h2>
    </div>

    {{ $slot }}

    <!-- Start Footer -->
    <footer class="py-5 text-center text-black dark:text-white/80 max-w-[1440px] mx-auto">
        <div>
            &copy;
            <span>{{ date('Y') }}</span>
            Porject.
            <span>Crafted with
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    class="w-4 h-4 inline-block relative -mt-[2px]">
                    <path
                        d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853Z"
                        class="fill-purple"></path>
                </svg>
                by TYDev
            </span>
        </div>
    </footer>
    <!-- End Footer -->

</div>

<x-layout.vendor-scripts scripts="{{ $scripts ?? '' }}" />

@livewireScripts
</body>

</html>
