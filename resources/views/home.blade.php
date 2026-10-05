<x-app-layout>
    <section class="relative overflow-hidden border-b border-gray-200 dark:border-gray-800">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,theme(colors.accent.100),transparent_60%)] dark:bg-[radial-gradient(ellipse_at_top,theme(colors.accent.950),transparent_60%)]"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center">
            <p class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white/70 px-3 py-1 text-xs font-medium text-gray-600 dark:border-gray-800 dark:bg-gray-900/70 dark:text-gray-300">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                A friendly community for programmers
            </p>
            <h1 class="mt-6 text-4xl sm:text-6xl font-bold tracking-tight">
                Ask. Answer. <span class="text-accent-600 dark:text-accent-400">Level up.</span>
            </h1>
            <p class="mx-auto mt-4 max-w-xl text-lg text-gray-600 dark:text-gray-400">
                Get unstuck on C++, Python, JavaScript and more, and help others along the way.
            </p>

            <form action="{{ route('search') }}" method="GET" role="search" aria-label="Questions" class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">
                <label for="hero-search" class="sr-only">Search questions</label>
                <input id="hero-search" type="search" name="q" placeholder="Search questions…"
                    class="flex-1 rounded-lg border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-accent-500 focus:ring-accent-500 dark:border-gray-700 dark:bg-gray-900">
                <x-button size="lg">Search</x-button>
            </form>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <section id="categories" class="py-12 scroll-mt-16" aria-labelledby="categories-heading">
            <div class="flex items-end justify-between">
                <div>
                    <h2 id="categories-heading" class="text-xl font-semibold tracking-tight">Browse categories</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pick a topic to read questions or ask your own.</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}"
                        class="group rounded-xl border border-gray-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-accent-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-accent-500/50">
                        <div class="flex items-center justify-between">
                            <x-category-icon :category="$category" class="group-hover:text-accent-600 dark:group-hover:text-accent-400" />
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $category->threads_count }} {{ Str::plural('thread', $category->threads_count) }}</span>
                        </div>
                        <h3 class="mt-4 font-semibold">{{ $category->name }}</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $category->description }}</p>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="pb-4" aria-labelledby="latest-heading">
            <h2 id="latest-heading" class="text-xl font-semibold tracking-tight">Latest questions</h2>
            @if ($latestThreads->isEmpty())
                <x-empty-state title="No questions yet" class="mt-6">Pick a category above and be the first to ask.</x-empty-state>
            @else
                <x-card class="mt-6 px-5">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach ($latestThreads as $thread)
                            <x-thread-row :thread="$thread" />
                        @endforeach
                    </ul>
                </x-card>
            @endif
        </section>
    </div>
</x-app-layout>
