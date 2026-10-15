@php($retryAfter = (int) ($exception->getHeaders()['Retry-After'] ?? 0))

<x-app-layout :title="__('Slow down')">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <p class="text-sm font-semibold text-accent-600 dark:text-accent-400">429</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight">{{ __('You\'re going a bit fast') }}</h1>
        <p class="mt-4 text-gray-600 dark:text-gray-400">
            {{ __('To keep Codingsols free of spam, there\'s a limit on how often you can post.') }}
            @if ($retryAfter > 0)
                {{ $retryAfter >= 60
                    ? trans_choice('Please try again in :count minute.|Please try again in :count minutes.', (int) ceil($retryAfter / 60))
                    : trans_choice('Please try again in :count second.|Please try again in :count seconds.', $retryAfter) }}
            @else
                {{ __('Please try again shortly.') }}
            @endif
        </p>
        <div class="mt-8 flex justify-center gap-3">
            <x-button :href="url()->previous() !== url()->current() ? url()->previous() : route('home')" variant="secondary">{{ __('Go back') }}</x-button>
            <x-button :href="route('home')">{{ __('Home') }}</x-button>
        </div>
    </div>
</x-app-layout>
