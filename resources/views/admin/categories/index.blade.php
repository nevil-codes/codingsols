<x-admin-layout title="Categories">
    <div class="mb-4 flex justify-end">
        <x-button :href="route('admin.categories.create')">New category</x-button>
    </div>
    <x-card class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-gray-200 text-xs uppercase tracking-wide text-gray-500 dark:border-gray-800 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-5 py-3 font-semibold">Name</th>
                    <th scope="col" class="px-5 py-3 font-semibold">Slug</th>
                    <th scope="col" class="px-5 py-3 font-semibold">Questions</th>
                    <th scope="col" class="px-5 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @foreach ($categories as $category)
                    <tr>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <x-category-icon :category="$category" class="h-8 w-8" />
                                <a href="{{ route('categories.show', $category) }}" class="font-medium hover:text-accent-600 dark:hover:text-accent-400">{{ $category->name }}</a>
                            </div>
                        </td>
                        <td class="px-5 py-3 font-mono text-gray-600 dark:text-gray-400">{{ $category->slug }}</td>
                        <td class="px-5 py-3 tabular-nums">{{ $category->threads_count }}</td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-2">
                                <x-button :href="route('admin.categories.edit', $category)" variant="ghost" size="sm">Edit<span class="sr-only"> {{ $category->name }}</span></x-button>
                                @if ($category->threads_count === 0)
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete {{ $category->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="ghost" size="sm" class="text-red-600 dark:text-red-400">Delete<span class="sr-only"> {{ $category->name }}</span></x-button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>
</x-admin-layout>
