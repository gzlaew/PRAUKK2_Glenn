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
<div class="bg-[#f9fbfd] text-black dark:bg-darklight bg-[url('../images/bg-shape.png')] bg-cover bg-no-repeat">

    <!-- Start Header -->
    <header>
        <nav class="px-4 lg:px-7 py-4 max-w-[1440px] mx-auto">
            <div class="flex flex-wrap items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ URL::asset('build/images/logo-dark.svg') }}" class="mx-auto dark-logo h-7 dark:hidden" alt="logo">
                    <img src="{{ URL::asset('build/images/logo-light.svg') }}" class="hidden mx-auto light-logo h-7 dark:block" alt="logo">
                </a>
                <div class="flex items-center lg:order-2">
                    <a href="https://themeforest.net/item/sliced-laravel-10-tailwind-css-admin-dashboard-template/47805927" target="_blank" class="btn bg-purple border border-purple rounded-md text-white transition-all duration-300 hover:bg-purple/[0.85] hover:border-purple/[0.85]">Buy Now</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header -->

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