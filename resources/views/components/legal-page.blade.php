@props(['lang', 'title', 'updated', 'other'])

<x-app-layout :title="$title" :description="$lang === 'de' ? $title.' von Codingsols.' : 'The '.Str::lower($title).' of Codingsols.'">
    <article lang="{{ $lang }}" class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <header class="border-b border-gray-200 pb-6 dark:border-gray-800">
            <div class="flex flex-wrap items-baseline justify-between gap-3">
                <h1 class="text-3xl font-bold tracking-tight">{{ $title }}</h1>
                <a href="{{ $other }}" hreflang="{{ $lang === 'de' ? 'en' : 'de' }}" class="text-sm text-accent-600 hover:underline dark:text-accent-400">
                    {{ $lang === 'de' ? 'English version' : 'Deutsche Fassung' }}
                </a>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ $lang === 'de' ? 'Stand:' : 'Last updated:' }}
                <time datetime="{{ $updated }}">{{ \Illuminate\Support\Carbon::parse($updated)->locale($lang)->isoFormat('LL') }}</time>
            </p>
        </header>

        <div class="prose prose-gray mt-8 max-w-none dark:prose-invert prose-headings:tracking-tight prose-a:text-accent-600 dark:prose-a:text-accent-400">
            {{ $slot }}
        </div>
    </article>
</x-app-layout>
