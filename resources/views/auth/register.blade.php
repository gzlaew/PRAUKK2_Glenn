<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <!-- Start Main Content -->
    <div class="min-h-[calc(100vh-134px)] py-4 px-4 sm:px-12 flex justify-center items-center max-w-[1440px] mx-auto">
        <div
            class="max-w-[550px] flex-none w-full bg-white border border-black/10 p-6 sm:p-10 lg:px-10 lg:py-14 rounded-2xl dark:bg-darklight dark:border-darkborder">
            <h1 class="mb-2 text-2xl font-semibold text-center dark:text-white">Sign Up</h1>
            <p class="text-center text-muted mb-7 dark:text-darkmuted">Enter your email and password to sign up!</p>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}" class="">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="mb-4">
                        <x-input id="name_first" type="text" name="name_first" :value="old('name_first')" required autofocus
                            autocomplete="name_first" placeholder="First Name" />
                    </div>
                    <div class="mb-4">
                        <x-input id="name_last" type="text" name="name_last" :value="old('name_last')" required autofocus
                            autocomplete="name_last" placeholder="Last Name" />
                    </div>
                </div>
                <div class="mb-4">
                    <x-input id="email" type="email" name="email" :value="old('email')" required
                        autocomplete="username" placeholder="Email" />
                </div>

                <div class="mb-4">
                    <x-input id="username" type="text" name="username" :value="old('username')" required
                        autocomplete="username" placeholder="Username" />
                </div>

                <div class="mb-4">
                    <x-input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="Password" />
                </div>

                <div class="mb-4">
                    <x-input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" placeholder="Confirm your password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mb-4">
                    <div>
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ms-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                    '<a target="_blank" href="' .
                                                route('terms.show') .
                                                '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                    '<a target="_blank" href="' .
                                                route('policy.show') .
                                                '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                </div>
                @endif

                <div>
                    <x-button class="w-full">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
            <p class="mt-5 text-center text-muted dark:text-darkmuted">Already a member? <a href="{{ route('login') }}"
                    class="text-black dark:text-white">Sign In</a></p>
        </div>
    </div>
    <!-- End Main Content -->
</x-guest-layout>