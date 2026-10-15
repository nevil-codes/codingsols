<x-app-layout title="{{ __('Notifications') }}">
    <x-slot name="header">
        <h1 class="text-2xl font-bold tracking-tight">{{ __('Notifications') }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Replies to your questions.') }}
            <a href="{{ route('profile.edit') }}#notifications" class="text-accent-600 hover:underline dark:text-accent-400">{{ __('Email settings') }}</a>
        </p>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($notifications->isEmpty())
            <x-empty-state title="{{ __('No notifications yet') }}">{{ __('When someone replies to one of your questions, it will show up here.') }}</x-empty-state>
        @else
            <x-card class="px-5">
                <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach ($notifications as $notification)
                        @php($data = $notification->data)
                        <li class="flex gap-3 py-4">
                            <span @class([
                                'mt-2 h-2 w-2 shrink-0 rounded-full',
                                'bg-accent-500' => $notification->read_at === null,
                                'bg-transparent' => $notification->read_at !== null,
                            ])>
                                @if ($notification->read_at === null)<span class="sr-only">{{ __('New:') }}</span>@endif
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm">
                                    @php($question = $existingThreads->contains($data['thread_id'])
                                        ? '<a href="'.e(route('threads.show', $data['thread_id'])).'#reply-'.(int) $data['comment_id'].'" class="font-medium text-accent-600 hover:underline dark:text-accent-400">'.e($data['thread_title']).'</a>'
                                        : '<span class="font-medium">'.e($data['thread_title']).'</span> <span class="text-gray-500 dark:text-gray-400">'.e(__('(deleted)')).'</span>')
                                    {!! __(':name replied to :question', ['name' => '<span class="font-medium">'.e($data['replier_name']).'</span>', 'question' => $question]) !!}
                                </p>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $data['excerpt'] }}</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </x-card>

            <div class="mt-6">{{ $notifications->links() }}</div>
        @endif
    </div>
</x-app-layout>
