@props(['thread', 'showCategory' => true, 'highlight' => [], 'matchedInReply' => false])

<li class="flex gap-4 py-5">
    <x-avatar :user="$thread->user" class="hidden sm:inline-flex" />
    <div class="min-w-0 flex-1">
        <a href="{{ route('threads.show', $thread) }}" class="font-semibold leading-snug hover:text-accent-600 dark:hover:text-accent-400">
            <x-highlight :text="$thread->title" :terms="$highlight" />
        </a>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2"><x-highlight :text="$thread->excerpt()" :terms="$highlight" /></p>
        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
            @if ($matchedInReply)
                <x-badge>Matched in a reply</x-badge>
            @endif
            @if ($showCategory)
                <x-badge :href="route('categories.show', $thread->category)">{{ $thread->category->name }}</x-badge>
            @endif
            <span>{{ $thread->user->name }}</span>
            <span aria-hidden="true">&middot;</span>
            <time datetime="{{ $thread->created_at->toIso8601String() }}" title="{{ $thread->created_at->toDayDateTimeString() }}">{{ $thread->created_at->diffForHumans() }}</time>
        </div>
    </div>
    <div class="shrink-0 self-center text-center">
        <div class="text-sm font-semibold {{ $thread->comments_count ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400' }}">{{ $thread->comments_count }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::plural('reply', $thread->comments_count) }}</div>
    </div>
</li>
