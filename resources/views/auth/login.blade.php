<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <!-- Start Main Content -->
    <div class="min-h-[calc(100vh-134px)] py-4 px-4 sm:px-12 flex justify-center items-center max-w-[1440px] mx-auto">
        <div
            class="max-w-[550px] flex-none w-full bg-white border border-black/10 p-6 sm:p-10 lg:px-10 lg:py-14 rounded-2xl loginform dark:bg-darklight dark:border-darkborder">
            <h1 class="mb-2 text-2xl font-semibold text-center dark:text-white">Sign In</h1>
            <p class="text-center text-muted mb-7 dark:text-darkmuted">Enter your email and password to sign in!</p>

            <x-validation-errors class="mb-4" />

            @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
            @endsession
            <form class="space-y-4" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <x-input id="email" type="text" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email or Username" />
                </div>
                <div>
                    <x-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                </div>
                <div class="ltr:text-right rtl:text-left">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-black dark:text-white">Forgot Password?</a>
                    @endif
                </div>
                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <x-button class="w-full">
                    {{ __('Log in') }}
                </x-button>
            </form>
            @if (Route::has('register'))
            <p class="mt-5 text-center text-muted dark:text-darkmuted"> Don't have an account yet? <a href="{{ route('register') }}" class="text-black dark:text-white">Sign up here</a>.</p>
            @endif
        </div>
    </div>
    <!-- End Main Content -->

    <x-slot name="scripts">
        <script src="{{ URL::asset('build/js/main.js') }}"></script>
    </x-slot>
</x-guest-layout>