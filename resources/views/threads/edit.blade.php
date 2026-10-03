<x-app-layout title="Edit question">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold tracking-tight">Edit question</h1>

        <form method="POST" action="{{ route('threads.update', $thread) }}" class="mt-8 space-y-6" x-data="{ tab: 'write', body: @js(old('body', $thread->body)) }">
            @csrf
            @method('PATCH')
            @include('threads.partials.form-fields')
            <div class="flex justify-end gap-3">
                <x-button :href="route('threads.show', $thread)" variant="ghost">Cancel</x-button>
                <x-button>Save changes</x-button>
            </div>
        </form>
    </div>
</x-app-layout>
