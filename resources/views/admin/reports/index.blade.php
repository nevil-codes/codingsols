<x-admin-layout title="Reports">
    @if ($groups->isEmpty())
        <x-empty-state title="No open reports">Reported questions and answers will show up here.</x-empty-state>
    @else
        <ul class="space-y-4">
            @foreach ($groups as $reports)
                @php($first = $reports->first())
                @php($post = $first->reportable)
                <li>
                    <x-card class="p-5">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    {{ $first->reportable_type === 'thread' ? 'Question' : 'Answer' }}
                                    &middot; {{ $reports->count() }} {{ Str::plural('report', $reports->count()) }}
                                </p>
                                @if ($post)
                                    @php($thread = $post instanceof App\Models\Thread ? $post : $post->thread)
                                    <a href="{{ route('threads.show', $thread) }}{{ $post instanceof App\Models\Comment ? '#reply-'.$post->id : '' }}"
                                        class="mt-1 block font-semibold hover:text-accent-600 dark:hover:text-accent-400">{{ $thread->title }}</a>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ Str::limit(strip_tags(App\Support\Markdown::render($post->body)), 200) }}</p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">by {{ $post->user->name }}</p>
                                @else
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This content no longer exists.</p>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <form method="POST" action="{{ route('admin.reports.dismiss', $first) }}">
                                    @csrf
                                    <x-button variant="secondary" size="sm">Dismiss</x-button>
                                </form>
                                @if ($post)
                                    @php($thread = $post instanceof App\Models\Thread ? $post : $post->thread)
                                    @unless ($thread->isLocked())
                                        <form method="POST" action="{{ route('threads.lock', $thread) }}">
                                            @csrf
                                            <x-button variant="secondary" size="sm">Lock thread</x-button>
                                        </form>
                                    @endunless
                                    <form method="POST" action="{{ route('admin.reports.remove', $first) }}" onsubmit="return confirm('Delete this {{ $first->reportable_type === 'thread' ? 'question and all its answers' : 'answer' }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="danger" size="sm">Delete {{ $first->reportable_type === 'thread' ? 'question' : 'answer' }}</x-button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <ul class="mt-4 space-y-2 border-t border-gray-200 pt-4 text-sm dark:border-gray-800">
                            @foreach ($reports as $report)
                                <li>
                                    <x-badge>{{ App\Models\Report::REASONS[$report->reason] ?? $report->reason }}</x-badge>
                                    <span class="text-gray-600 dark:text-gray-400">from {{ $report->user->name }}, {{ $report->created_at->diffForHumans() }}</span>
                                    @if ($report->details)
                                        <p class="mt-1 text-gray-700 dark:text-gray-300">“{{ $report->details }}”</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </x-card>
                </li>
            @endforeach
        </ul>
    @endif
</x-admin-layout>
