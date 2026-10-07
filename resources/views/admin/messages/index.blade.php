<x-admin-layout title="Messages">
    @if ($messages->isEmpty())
        <x-empty-state title="No messages">Messages sent through the contact form will show up here.</x-empty-state>
    @else
        <ul class="space-y-4">
            @foreach ($messages as $message)
                <li>
                    <x-card class="p-5">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold">{{ $message->name }}</p>
                                <a href="mailto:{{ $message->email }}" class="text-sm text-accent-600 hover:underline dark:text-accent-400">{{ $message->email }}</a>
                                <span class="text-sm text-gray-500 dark:text-gray-400">&middot; {{ $message->created_at->diffForHumans() }}</span>
                            </div>
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                                @csrf
                                @method('DELETE')
                                <x-button variant="ghost" size="sm" class="text-red-600 dark:text-red-400">Delete</x-button>
                            </form>
                        </div>
                        <p class="mt-3 whitespace-pre-line text-sm text-gray-700 dark:text-gray-300">{{ $message->message }}</p>
                    </x-card>
                </li>
            @endforeach
        </ul>
        <div class="mt-6">{{ $messages->links() }}</div>
    @endif
</x-admin-layout>
