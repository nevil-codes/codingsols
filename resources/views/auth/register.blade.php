<x-guest-layout title="Sign up">
    <form method="POST" action="{{ route('register') }}" class="relative">
        @csrf
        <x-honeypot />

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms -->
        <div class="mt-5">
            <label for="terms" class="flex items-start gap-3">
                <input id="terms" type="checkbox" name="terms" value="1" required @checked(old('terms'))
                    class="mt-0.5 rounded border-gray-300 text-accent-600 focus:ring-accent-500 dark:border-gray-700 dark:bg-gray-900"
                    aria-describedby="privacy-notice">
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    I agree to the <a href="{{ \App\Support\LegalLocale::url('terms') }}" target="_blank" class="font-medium text-accent-600 hover:underline dark:text-accent-400">{{ \App\Support\LegalLocale::for(request()) === 'de' ? 'Terms of Use (Nutzungsbedingungen)' : 'Terms of Use' }}</a>.
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />

            <p id="privacy-notice" class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                We use your name and email to run your account. Read how we handle your data in our
                <a href="{{ \App\Support\LegalLocale::url('privacy') }}" target="_blank" class="underline hover:text-gray-900 dark:hover:text-gray-100">{{ \App\Support\LegalLocale::for(request()) === 'de' ? 'Privacy Policy (Datenschutzerklärung)' : 'Privacy Policy' }}</a>.
            </p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
