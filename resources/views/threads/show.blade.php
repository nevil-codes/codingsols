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
                    @if ($thread->updated_at->gt($thread->created_at->addMinute()))
                        <span aria-hidden="true">&middot;</span>
                        <span>edited</span>
                    @endif
                </div>

                <x-card class="mt-6 p-6">
                    <x-markdown :body="$thread->body" />

                    @canany(['update', 'delete'], $thread)
                        <div class="mt-6 flex gap-2 border-t border-gray-200 pt-4 dark:border-gray-800">
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
                        </div>
                    @endcanany
                </x-card>
            </article>

            <section class="mt-10" aria-labelledby="replies-heading">
                <h2 id="replies-heading" class="text-lg font-semibold">
                    {{ $thread->comments->count() }} {{ Str::plural('reply', $thread->comments->count()) }}
                </h2>

                @if ($thread->comments->isEmpty())
                    <x-empty-state title="No replies yet" class="mt-4">Know the answer? Help out below.</x-empty-state>
                @else
                    <ol class="mt-4 space-y-4">
                        @foreach ($thread->comments as $comment)
                            <li id="reply-{{ $comment->id }}" class="scroll-mt-20">
                                <x-card class="p-5">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 text-sm">
                                            <x-avatar :user="$comment->user" size="sm" />
                                            <span class="font-medium">{{ $comment->user->name }}</span>
                                            @if ($comment->user_id === $thread->user_id)
                                                <x-badge>Author</x-badge>
                                            @endif
                                            <time class="text-gray-500 dark:text-gray-400" datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->diffForHumans() }}</time>
                                        </div>
                                        @can('delete', $comment)
                                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('Delete this reply?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-xs text-gray-500 hover:text-red-600 dark:hover:text-red-400">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                    <x-markdown :body="$comment->body" class="mt-3 prose-sm" />
                                </x-card>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </section>

            <section class="mt-10" aria-labelledby="reply-form-heading">
                <h2 id="reply-form-heading" class="text-lg font-semibold">Your answer</h2>
                @auth
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
                @endauth
            </section>
        </div>

        <aside class="space-y-4">
            <x-card class="p-5">
                <div class="flex items-center gap-3">
                    <x-category-icon :category="$thread->category" />
                    <div>
                        <div class="text-xs text-gray-500">Category</div>
                        <a href="{{ route('categories.show', $thread->category) }}" class="font-semibold hover:text-accent-600 dark:hover:text-accent-400">{{ $thread->category->name }}</a>
                    </div>
                </div>
                <x-button :href="route('threads.create', $thread->category)" variant="secondary" size="sm" class="mt-4 w-full">Ask a question</x-button>
            </x-card>
            <x-forum-rules />
        </aside>
    </div>
</x-app-layout>
