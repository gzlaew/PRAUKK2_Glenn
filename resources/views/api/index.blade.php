<x-app-layout>
    <x-slot name="title">
        {{ __('API Tokens') }}
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('api.api-token-manager')
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ URL::asset('build/js/main.js') }}"></script>
    </x-slot>
</x-app-layout>
