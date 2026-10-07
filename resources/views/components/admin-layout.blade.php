@props(['title'])

<x-app-layout :title="$title.' · Admin'">
    <x-slot name="header">
        <p class="text-sm font-semibold text-accent-600 dark:text-accent-400">Admin</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight">{{ $title }}</h1>
        <nav class="mt-4 flex flex-wrap gap-1" aria-label="Admin">
            @foreach ([
                'admin.dashboard' => 'Overview',
                'admin.reports.index' => 'Reports',
                'admin.categories.index' => 'Categories',
                'admin.messages.index' => 'Messages',
            ] as $route => $label)
                @php($active = request()->routeIs(Str::beforeLast($route, '.index').'*'))
                <a href="{{ route($route) }}" @class([
                    'rounded-md px-3 py-1.5 text-sm font-medium',
                    'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' => $active,
                    'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' => ! $active,
                ]) @if ($active) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </div>
</x-app-layout>
