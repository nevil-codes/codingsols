<x-app-layout title="Ask a question">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
            <a href="{{ route('categories.show', $category) }}" class="hover:text-gray-900 dark:hover:text-white">{{ $category->name }}</a>
            <span aria-hidden="true" class="mx-1">/</span>
            <span class="text-gray-900 dark:text-white">Ask a question</span>
        </nav>
        <h1 class="mt-4 text-2xl font-bold tracking-tight">Ask a {{ $category->name }} question</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Be specific. Include code, the full error message and what you already tried.</p>

        <form method="POST" action="{{ route('threads.store', $category) }}" class="mt-8 space-y-6" x-data="{ tab: 'write', body: @js(old('body', '')) }">
            @csrf
            @include('threads.partials.form-fields')
            <div class="flex justify-end gap-3">
                <x-button :href="route('categories.show', $category)" variant="ghost">Cancel</x-button>
                <x-button>Post question</x-button>
            </div>
        </form>
    </div>
</x-app-layout>
