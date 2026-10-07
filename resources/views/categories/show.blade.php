<x-app-layout :title="$category->name">
    <x-slot name="header">
        <nav class="text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
            <a href="{{ route('home') }}#categories" class="hover:text-gray-900 dark:hover:text-white">Categories</a>
            <span aria-hidden="true" class="mx-1">/</span>
            <span class="text-gray-900 dark:text-white">{{ $category->name }}</span>
        </nav>
        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <x-category-icon :category="$category" class="h-14 w-14" />
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">{{ $category->name }}</h1>
                    <p class="mt-1 max-w-2xl text-sm text-gray-600 dark:text-gray-400">{{ $category->description }}</p>
                </div>
            </div>
            <x-button :href="route('threads.create', $category)" class="shrink-0">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" /></svg>
                Ask a question
            </x-button>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid gap-8 lg:grid-cols-[1fr_18rem]">
        <section aria-label="Questions">
            <x-sort-tabs :current="$sort" class="mb-4" />
            @if ($threads->isEmpty())
                <x-empty-state title="No questions yet">
                    Be the first to ask something about {{ $category->name }}.
                </x-empty-state>
            @else
                <x-card class="px-5">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach ($threads as $thread)
                            <x-thread-row :thread="$thread" :show-category="false" />
                        @endforeach
                    </ul>
                </x-card>
                <div class="mt-6">{{ $threads->links() }}</div>
            @endif
        </section>

        <aside class="space-y-4">
            <x-forum-rules />
        </aside>
    </div>
</x-app-layout>
