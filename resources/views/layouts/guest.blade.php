<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10">
            <header>
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-lg tracking-tight">
                    <x-application-logo class="h-9 w-9" />
                    <span>codingsols</span>
                </a>
            </header>

            <main class="w-full sm:max-w-md mt-8 px-6 py-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm">
                @if ($title)
                    <h1 class="mb-6 text-xl font-semibold tracking-tight">{{ $title }}</h1>
                @endif

                {{ $slot }}
            </main>

            <footer class="mt-6" x-data="themeToggle">
                <x-theme-toggle />
            </footer>
        </div>
    </body>
</html>
