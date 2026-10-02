<footer class="border-t border-gray-200 dark:border-gray-800 mt-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row gap-4 items-center justify-between text-sm text-gray-500 dark:text-gray-400">
        <div class="flex items-center gap-2">
            <x-application-logo class="h-5 w-5" />
            <span>&copy; {{ date('Y') }} Codingsols. Built by developers, for developers.</span>
        </div>
        <nav class="flex gap-6" aria-label="Footer">
            <a href="{{ route('about') }}" class="hover:text-gray-900 dark:hover:text-white">About</a>
            <a href="{{ route('contact') }}" class="hover:text-gray-900 dark:hover:text-white">Contact</a>
            <a href="https://github.com/nevil-codes/codingsols" class="hover:text-gray-900 dark:hover:text-white">GitHub</a>
        </nav>
    </div>
</footer>
