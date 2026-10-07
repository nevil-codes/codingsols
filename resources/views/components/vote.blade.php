@props(['votable', 'action', 'myVote' => 0, 'noun' => 'post', 'locked' => false])

@php
$user = auth()->user();
$canVote = ! $locked && $user && $user->hasVerifiedEmail() && $user->id !== $votable->user_id;
$button = 'flex h-9 w-9 items-center justify-center rounded-full ring-1 ring-inset transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500';
$idle = 'text-gray-500 ring-gray-200 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-gray-800 dark:hover:text-white';
$up = 'bg-accent-600 text-white ring-accent-600';
$down = 'bg-rose-600 text-white ring-rose-600';
$arrowUp = '<svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .55.24l5.25 5.5a.75.75 0 1 1-1.1 1.02L10.75 5.62V16.25a.75.75 0 0 1-1.5 0V5.62L5.3 9.76a.75.75 0 1 1-1.1-1.02l5.25-5.5A.75.75 0 0 1 10 3Z" clip-rule="evenodd"/></svg>';
$arrowDown = '<svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.55-.24l-5.25-5.5a.75.75 0 1 1 1.1-1.02l3.95 4.14V3.75a.75.75 0 0 1 1.5 0v10.63l3.95-4.14a.75.75 0 1 1 1.1 1.02l-5.25 5.5A.75.75 0 0 1 10 17Z" clip-rule="evenodd"/></svg>';
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col items-center gap-1']) }}>
    @if ($canVote)
        <form method="POST" action="{{ $action }}">
            @csrf
            <input type="hidden" name="value" value="1">
            <button type="submit" class="{{ $button }} {{ $myVote === 1 ? $up : $idle }}" aria-pressed="{{ $myVote === 1 ? 'true' : 'false' }}" aria-label="Upvote this {{ $noun }}">{!! $arrowUp !!}</button>
        </form>
    @elseif (! $user && ! $locked)
        <a href="{{ route('login') }}" class="{{ $button }} {{ $idle }}" aria-label="Log in to vote on this {{ $noun }}">{!! $arrowUp !!}</a>
    @endif

    <span class="min-w-[2ch] text-center text-sm font-semibold tabular-nums {{ $votable->score > 0 ? 'text-accent-700 dark:text-accent-300' : ($votable->score < 0 ? 'text-rose-700 dark:text-rose-300' : 'text-gray-700 dark:text-gray-300') }}">
        <span class="sr-only">Score:</span> {{ $votable->score }}
    </span>

    @if ($canVote)
        <form method="POST" action="{{ $action }}">
            @csrf
            <input type="hidden" name="value" value="-1">
            <button type="submit" class="{{ $button }} {{ $myVote === -1 ? $down : $idle }}" aria-pressed="{{ $myVote === -1 ? 'true' : 'false' }}" aria-label="Downvote this {{ $noun }}">{!! $arrowDown !!}</button>
        </form>
    @elseif (! $user && ! $locked)
        <a href="{{ route('login') }}" class="{{ $button }} {{ $idle }}" aria-label="Log in to vote on this {{ $noun }}">{!! $arrowDown !!}</a>
    @endif
</div>
