<x-app-layout title="{{ __('My activity') }}">
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <x-avatar :user="Auth::user()" size="lg" />
            <div>
                <h1 class="text-2xl font-bold tracking-tight">{{ Auth::user()->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Member since :date', ['date' => Auth::user()->created_at->translatedFormat('F Y')]) }}
                    &middot; {{ trans_choice(':count question|:count questions', $threads->count()) }}
                    &middot; {{ trans_choice(':count reply|:count replies', Auth::user()->comments()->count()) }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid gap-8 lg:grid-cols-2">
        <section aria-labelledby="my-questions">
            <h2 id="my-questions" class="font-semibold">{{ __('Your questions') }}</h2>
            @if ($threads->isEmpty())
                <x-empty-state title="{{ __('No questions yet') }}" class="mt-4">
                    {!! __(':link and ask your first one.', ['link' => '<a href="'.e(route('home')).'#categories" class="text-accent-600 hover:underline dark:text-accent-400">'.e(__('Pick a category')).'</a>']) !!}
                </x-empty-state>
            @else
                <x-card class="mt-4 px-5">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach ($threads as $thread)
                            <li class="flex items-center justify-between gap-4 py-4">
                                <div class="min-w-0">
                                    <a href="{{ route('threads.show', $thread) }}" class="font-medium hover:text-accent-600 dark:hover:text-accent-400">{{ $thread->title }}</a>
                                    <div class="mt-1 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                        <x-badge>{{ $thread->category->name }}</x-badge>
                                        {{ $thread->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <span class="shrink-0 text-sm text-gray-500 dark:text-gray-400">{{ trans_choice(':count reply|:count replies', $thread->comments_count) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </x-card>
            @endif
        </section>

        <section aria-labelledby="my-replies">
            <h2 id="my-replies" class="font-semibold">{{ __('Recent replies') }}</h2>
            @if ($comments->isEmpty())
                <x-empty-state title="{{ __('No replies yet') }}" class="mt-4">{{ __('Answer a question to help someone out.') }}</x-empty-state>
            @else
                <x-card class="mt-4 px-5">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach ($comments as $comment)
                            <li class="py-4">
                                <a href="{{ route('threads.show', $comment->thread) }}#reply-{{ $comment->id }}" class="text-sm font-medium hover:text-accent-600 dark:hover:text-accent-400">{{ $comment->thread->title }}</a>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ Str::limit($comment->body, 160) }}</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </li>
                        @endforeach
                    </ul>
                </x-card>
            @endif
        </section>
    </div>
</x-app-layout>
