<x-app-layout title="About">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <p class="text-sm font-semibold text-accent-600 dark:text-accent-400">About</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-bold tracking-tight">Welcome to the Codingsols family</h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
            Codingsols is a community forum where programmers of every level ask questions, share answers and learn from each other.
        </p>

        <div class="mt-12 grid gap-6 sm:grid-cols-3">
            @foreach ([
                ['1', 'Pick a category', 'Choose the language or framework your problem is about.'],
                ['2', 'Ask clearly', 'Share your code, the exact error and what you already tried.'],
                ['3', 'Pay it forward', 'Answer questions you know. Teaching is the fastest way to learn.'],
            ] as [$step, $heading, $text])
                <x-card class="p-5">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-accent-50 text-sm font-semibold text-accent-700 dark:bg-accent-500/10 dark:text-accent-300">{{ $step }}</span>
                    <h2 class="mt-3 font-semibold">{{ $heading }}</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $text }}</p>
                </x-card>
            @endforeach
        </div>

        <x-forum-rules class="mt-12" />

        <div class="mt-12 flex flex-wrap gap-3">
            <x-button :href="route('home').'#categories'">Browse categories</x-button>
            <x-button :href="route('contact')" variant="secondary">Contact us</x-button>
        </div>
    </div>
</x-app-layout>
