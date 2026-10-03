<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="font-sans antialiased bg-white text-gray-900 dark:bg-gray-950 dark:text-gray-100">
        <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-50 focus:rounded-md focus:bg-accent-600 focus:px-3 focus:py-2 focus:text-white">
            Skip to content
        </a>

        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b border-gray-200 dark:border-gray-800">
                    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main id="main" class="flex-1">
                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>

        <x-flash />
    </body>
</html>
