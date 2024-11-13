<x-app-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>
    <x-layout.page-title title="Porject" subtitle="Dashboard" />



    <x-slot name="scripts">
        <script src="{{ URL::asset('build/js/main.js') }}"></script>
    </x-slot>
</x-app-layout>