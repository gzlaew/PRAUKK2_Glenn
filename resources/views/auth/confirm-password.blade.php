<x-guest-layout>
    <x-slot name="title">Confirm Password</x-slot>

    <!-- Start Main Content -->
    <div class="min-h-[calc(100vh-134px)] py-4 px-4 sm:px-12 flex justify-center items-center max-w-[1440px] mx-auto">
        <div
            class="max-w-[550px] flex-none w-full bg-white border border-black/10 p-6 sm:p-10 lg:px-10 lg:py-14 rounded-2xl dark:bg-darklight dark:border-darkborder">
            <h1 class="mb-2 text-2xl font-semibold text-center dark:text-white">Confirm Password</h1>
            <p class="text-center text-muted mb-7 dark:text-darkmuted">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-4">
                    <x-input id="password" type="password" name="password" required autocomplete="current-password" autofocus placeholder="Enter your password" />
                </div>
    
                <div>
                    <x-button type="submit" class="w-full">
                        {{ __('Confirm') }}
                    </x-button>
                </div>
            </form>
            
        </div>
    </div>
    <!-- End Main Content -->
</x-guest-layout>
