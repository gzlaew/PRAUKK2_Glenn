<x-guest-layout>
    <x-slot name="title">Two Factor Authentication</x-slot>

    <!-- Start Main Content -->
    <div class="min-h-[calc(100vh-134px)] py-4 px-4 sm:px-12 flex justify-center items-center max-w-[1440px] mx-auto">
        <div x-data="{ recovery: false }"
            class="max-w-[550px] flex-none w-full bg-white border border-black/10 p-6 sm:p-10 lg:px-10 lg:py-14 rounded-2xl dark:bg-darklight dark:border-darkborder">
            <h1 class="mb-2 text-2xl font-semibold text-center dark:text-white">Two Factor Authentication</h1>

            <p class="text-center text-muted mb-7 dark:text-darkmuted" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </p>

            <p class="text-center text-muted mb-7 dark:text-darkmuted" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes') }}
            </p>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="mb-3" x-show="! recovery">
                    <x-input id="code" type="text" inputmode="numeric" name="code" autofocus x-ref="code" placeholder="Enter authentication code"
                        autocomplete="one-time-code" />
                </div>

                <div class="mb-3" x-cloak x-show="recovery">
                    <x-input id="recovery_code" type="text" name="recovery_code" x-ref="recovery_code" placeholder="Enter recovery code"
                        autocomplete="one-time-code" />
                </div>
                <div class="mb-3 flex items-center justify-end">
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                        x-show="! recovery" x-on:click="recovery = true;$nextTick(() => { $refs.recovery_code.focus() })">
                        {{ __('Use a recovery code') }}
                    </button>
    
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                        x-cloak x-show="recovery" x-on:click="recovery = false;$nextTick(() => { $refs.code.focus() })">
                        {{ __('Use an authentication code') }}
                    </button>
    
                </div>
    
                <x-button class="w-full">
                    {{ __('Log in') }}
                </x-button>
            </form>

        </div>
    </div>
    <!-- End Main Content -->
</x-guest-layout>
