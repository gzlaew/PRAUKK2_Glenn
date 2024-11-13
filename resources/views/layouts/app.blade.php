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
<div class="bg-[#f9fbfd] dark:bg-dark">

    <!-- Start detached bg -->
    <div
        class="bg-[url('../images/bg-main.png')] bg-black group-data-[sidebar=dark]/item:bg-darklight group-data-[sidebar=brand]/item:bg-sky-950 min-h-[220px] sm:min-h-[250px] bg-bottom fixed hidden w-full -z-50 detached-img">
    </div>
    <!-- End detached bg -->

    <!-- Start Menu Sidebar Olverlay -->
    <div x-cloak class="fixed inset-0 bg-black/60 dark:bg-dark/90 z-[10] lg:hidden"
        :class="{ 'hidden': !$store.app.sidebar }" @click="$store.app.toggleSidebar()"></div>
    <!-- End Menu Sidebar Olverlay -->

    <!-- Start Main Content -->
    <div class="flex mx-auto main-container">

        <x-layout.sidebar />

        <!-- Start Content Area -->
        <div class="flex-1 main-content">

            <x-layout.topbar />

            <!-- Start Content -->
            <div class="h-[calc(100vh-60px)] relative overflow-y-auto overflow-x-hidden p-4 space-y-4 detached-content">
                {{ $slot }}

                <x-layout.footer />
            </div>
        </div>
        <!-- End Content Area -->

    </div>
</div>

@stack('modals')

@livewireScripts

<x-layout.vendor-scripts scripts="{{ $scripts ?? '' }}" />

</body>

</html>