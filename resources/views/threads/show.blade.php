<x-app-layout :title="$thread->title">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid gap-8 lg:grid-cols-[1fr_18rem]">
        <div class="min-w-0">
            <nav class="text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
                <a href="{{ route('home') }}#categories" class="hover:text-gray-900 dark:hover:text-white">Categories</a>
                <span aria-hidden="true" class="mx-1">/</span>
                <a href="{{ route('categories.show', $thread->category) }}" class="hover:text-gray-900 dark:hover:text-white">{{ $thread->category->name }}</a>
            </nav>

            <article class="mt-4">
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ $thread->title }}</h1>
                <div class="mt-3 flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                    <x-avatar :user="$thread->user" size="sm" />
                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $thread->user->name }}</span>
                    <span aria-hidden="true">&middot;</span>
                    <time datetime="{{ $thread->created_at->toIso8601String() }}">asked {{ $thread->created_at->diffForHumans() }}</time>
                    @if ($thread->edited_at)
                        <span aria-hidden="true">&middot;</span>
                        <span>edited</span>
                    @endif
                </div>

                @if ($thread->tags->isNotEmpty())
                    <div class="mt-3 flex flex-wrap gap-2" aria-label="Tags">
                        @foreach ($thread->tags as $tag)
                            <x-tag :tag="$tag" />
                        @endforeach
                    </div>
                @endif

                @if ($thread->isLocked())
                    <div class="mt-6 flex items-start gap-3 rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-500/40 dark:bg-amber-500/10 dark:text-amber-200" role="status">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 0 0-4.5 4.5V9H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-.5V5.5A4.5 4.5 0 0 0 10 1Zm3 8V5.5a3 3 0 1 0-6 0V9h6Z" clip-rule="evenodd"/></svg>
                        <p>This question is locked by a moderator. It can't receive new answers or votes.</p>
                    </div>
                @endif

                <x-card class="mt-6 flex gap-4 p-6">
                    <x-vote :votable="$thread" :locked="$thread->isLocked()" :action="route('threads.vote', $thread)" :my-vote="$myVotes['thread:'.$thread->id] ?? 0" noun="question" class="shrink-0" />
                    <div class="min-w-0 flex-1">
                    <x-markdown :body="$thread->body" />

                    @auth
                        <div class="mt-6 flex flex-wrap items-center gap-2 border-t border-gray-200 pt-4 dark:border-gray-800">
                            @can('update', $thread)
                                <x-button :href="route('threads.edit', $thread)" variant="ghost" size="sm">Edit</x-button>
                            @endcan
                            @can('delete', $thread)
                                <form method="POST" action="{{ route('threads.destroy', $thread) }}" onsubmit="return confirm('Delete this question and all its replies?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="ghost" size="sm" class="text-red-600 dark:text-red-400">Delete</x-button>
                                </form>
                            @endcan
                            @can('lock', $thread)
                                <form method="POST" action="{{ $thread->isLocked() ? route('threads.unlock', $thread) : route('threads.lock', $thread) }}">
                                    @csrf
                                    @if ($thread->isLocked())
                                        @method('DELETE')
                                    @endif
                                    <x-button variant="ghost" size="sm">{{ $thread->isLocked() ? 'Unlock' : 'Lock' }}</x-button>
                                </form>
                            @endcan
                            @can('report', $thread)
                                <div class="ml-auto"><x-report-form :action="route('threads.report', $thread)" noun="question" /></div>
                            @endcan
                        </div>
                    @endauth
                    </div>
                </x-card>
            </article>

            <section class="mt-10" aria-labelledby="replies-heading">
                <h2 id="replies-heading" class="text-lg font-semibold">
                    {{ $comments->count() }} {{ Str::plural('reply', $comments->count()) }}
                </h2>

                @if ($comments->isEmpty())
                    <x-empty-state title="No replies yet" class="mt-4">Know the answer? Help out below.</x-empty-state>
                @else
                    <ol class="mt-4 space-y-4">
                        @foreach ($comments as $comment)
                            @php($accepted = $comment->id === $thread->accepted_comment_id)
                            <li id="reply-{{ $comment->id }}" class="scroll-mt-20">
                                <x-card @class(['flex gap-4 p-5', 'border-emerald-300 ring-1 ring-emerald-300 dark:border-emerald-500/50 dark:ring-emerald-500/50' => $accepted])>
                                    <x-vote :votable="$comment" :locked="$thread->isLocked()" :action="route('comments.vote', $comment)" :my-vote="$myVotes['comment:'.$comment->id] ?? 0" noun="answer" class="shrink-0" />
                                    <div class="min-w-0 flex-1">
                                    @if ($accepted)
                                        <p class="mb-3 inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 4.15a.75.75 0 0 1 .15 1.05l-8 10.5a.75.75 0 0 1-1.13.08l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.9 3.9 7.46-9.82a.75.75 0 0 1 1.06-.15Z" clip-rule="evenodd"/></svg>
                                            Accepted answer
                                        </p>
                                    @endif
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 text-sm">
                                            <x-avatar :user="$comment->user" size="sm" />
                                            <span class="font-medium">{{ $comment->user->name }}</span>
                                            @if ($comment->user_id === $thread->user_id)
                                                <x-badge>Author</x-badge>
                                            @endif
                                            <time class="text-gray-500 dark:text-gray-400" datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->diffForHumans() }}</time>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @can('acceptAnswer', $thread)
                                                @if ($accepted)
                                                    <form method="POST" action="{{ route('threads.unaccept', $thread) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Unaccept</button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('threads.accept', [$thread, $comment]) }}">
                                                        @csrf
                                                        <button class="text-xs font-medium text-emerald-700 hover:underline dark:text-emerald-300">Accept answer</button>
                                                    </form>
                                                @endif
                                            @endcan
                                            @can('report', $comment)
                                                <x-report-form :action="route('comments.report', $comment)" noun="answer" />
                                            @endcan
                                            @can('delete', $comment)
                                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('Delete this reply?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-xs text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <x-markdown :body="$comment->body" class="mt-3 prose-sm" />
                                    </div>
                                </x-card>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </section>

            <section class="mt-10" aria-labelledby="reply-form-heading">
                <h2 id="reply-form-heading" class="text-lg font-semibold">Your answer</h2>
                @if ($thread->isLocked())
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">This question is locked, so new answers are closed.</p>
                @elseif (auth()->check())
                    @if (auth()->user()->hasVerifiedEmail())
                        <form method="POST" action="{{ route('comments.store', $thread) }}" class="mt-4" x-data="{ tab: 'write', body: @js(old('body', '')) }">
                            @csrf
                            @include('threads.partials.editor', ['name' => 'body', 'placeholder' => 'Write your answer. Markdown and ```code blocks``` are supported.'])
                            <div class="mt-4 flex justify-end">
                                <x-button>Post answer</x-button>
                            </div>
                        </form>
                    @else
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            <a href="{{ route('verification.notice') }}" class="font-medium text-accent-600 hover:underline dark:text-accent-400">Verify your email</a> to post answers.
                        </p>
                    @endif
                @else
                    <x-card class="mt-4 p-5 text-sm text-gray-600 dark:text-gray-400">
                        <a href="{{ route('login') }}" class="font-medium text-accent-600 hover:underline dark:text-accent-400">Log in</a>
                        or
                        <a href="{{ route('register') }}" class="font-medium text-accent-600 hover:underline dark:text-accent-400">create an account</a>
                        to answer this question.
                    </x-card>
                @endif
            </section>
        </div>

        <aside class="space-y-4">
            <x-card class="p-5">
                <div class="flex items-center gap-3">
                    <x-category-icon :category="$thread->category" />
                    <div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Category</div>
                        <a href="{{ route('categories.show', $thread->category) }}" class="font-semibold hover:text-accent-600 dark:hover:text-accent-400">{{ $thread->category->name }}</a>
                    </div>
                </div>
                <x-button :href="route('threads.create', $thread->category)" variant="secondary" size="sm" class="mt-4 w-full">Ask a question</x-button>
            </x-card>
            <x-forum-rules />
        </aside>
    </div>
</x-app-layout>
