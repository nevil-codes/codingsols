<x-app-layout :title="$query !== '' ? 'Search: '.$query : 'Search'">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold tracking-tight">Search</h1>

        <form action="{{ route('search') }}" method="GET" role="search" aria-label="Search page" class="mt-6 flex gap-3">
            <label for="search-q" class="sr-only">Search questions</label>
            <x-text-input id="search-q" type="search" name="q" :value="$query" placeholder="Search questions…" class="flex-1" autofocus />
            <x-button>Search</x-button>
        </form>

        @if ($threads === null)
            <p class="mt-8 text-sm text-gray-500 dark:text-gray-400">Type a keyword, error message or library name.</p>
        @elseif ($threads->isEmpty())
            <x-empty-state title="No results" class="mt-8">
                Nothing matched “{{ $query }}”. Try different keywords, or ask a new question in one of the categories.
            </x-empty-state>
        @else
            <p class="mt-8 text-sm text-gray-500 dark:text-gray-400">{{ $threads->total() }} {{ Str::plural('result', $threads->total()) }} for “{{ $query }}”</p>
            <x-card class="mt-4 px-5">
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
