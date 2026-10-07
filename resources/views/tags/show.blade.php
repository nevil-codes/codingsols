<x-app-layout :title="'#'.$tag->name">
    <x-slot name="header">
        <nav class="text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
            <a href="{{ route('tags.index') }}" class="hover:text-gray-900 dark:hover:text-white">Tags</a>
            <span aria-hidden="true" class="mx-1">/</span>
            <span class="text-gray-900 dark:text-white">{{ $tag->name }}</span>
        </nav>
        <h1 class="mt-4 font-mono text-2xl font-bold tracking-tight"><span aria-hidden="true" class="text-gray-500 dark:text-gray-400">#</span>{{ $tag->name }}</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $threads->total() }} {{ Str::plural('question', $threads->total()) }} tagged {{ $tag->name }}</p>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-sort-tabs :current="$sort" class="mb-4" />
        @if ($threads->isEmpty())
            <x-empty-state title="No questions with this tag">Questions tagged {{ $tag->name }} will show up here.</x-empty-state>
        @else
            <x-card class="px-5">
                <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach ($threads as $thread)
                        <x-thread-row :thread="$thread" />
                    @endforeach
                </ul>
            </x-card>
            <div class="mt-6">{{ $threads->links() }}</div>
        @endif
    </div>
</x-app-layout>
