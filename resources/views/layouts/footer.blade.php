<footer class="border-t border-gray-200 dark:border-gray-800 mt-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row gap-4 items-center justify-between text-sm text-gray-500 dark:text-gray-400">
        <div class="flex items-center gap-2">
            <x-application-logo class="h-5 w-5" />
            <span>&copy; {{ date('Y') }} Codingsols. {{ __('Built by developers, for developers.') }}</span>
        </div>
        <nav class="flex flex-wrap justify-center gap-x-6 gap-y-2" aria-label="{{ __('Footer') }}">
            <a href="{{ route('about') }}" class="hover:text-gray-900 dark:hover:text-white">{{ __('About') }}</a>
            <a href="{{ route('contact') }}" class="hover:text-gray-900 dark:hover:text-white">{{ __('Contact') }}</a>
            <a href="{{ route('legal.privacy') }}" class="hover:text-gray-900 dark:hover:text-white">{{ __('Privacy') }}</a>
            <a href="{{ route('legal.terms') }}" class="hover:text-gray-900 dark:hover:text-white">{{ __('Terms') }}</a>
            <a href="https://github.com/nevil-codes/codingsols" class="hover:text-gray-900 dark:hover:text-white">GitHub</a>
        </nav>
    </div>
</footer>
