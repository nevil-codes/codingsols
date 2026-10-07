<x-app-layout title="Tags">
    <x-slot name="header">
        <h1 class="text-2xl font-bold tracking-tight">Tags</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Topics people are asking about across all categories.</p>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($tags->isEmpty())
            <x-empty-state title="No tags yet">Add tags when you ask a question to help others find it.</x-empty-state>
        @else
            <ul class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($tags as $tag)
                    <li>
                        <a href="{{ route('tags.show', $tag) }}"
                            class="flex items-center justify-between rounded-xl border border-gray-200 bg-white px-4 py-3 transition hover:border-accent-300 hover:shadow-sm dark:border-gray-800 dark:bg-gray-900 dark:hover:border-accent-500/50">
                            <span class="min-w-0 truncate font-mono text-sm font-medium" title="{{ $tag->name }}"><span aria-hidden="true" class="text-gray-500 dark:text-gray-400">#</span>{{ $tag->name }}</span>
                            <span class="ml-3 shrink-0 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">{{ $tag->threads_count }} {{ Str::plural('question', $tag->threads_count) }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
