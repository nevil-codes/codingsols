<x-admin-layout :title="$category->exists ? 'Edit '.$category->name : 'New category'">
    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="max-w-xl space-y-5">
        @csrf
        @if ($category->exists)
            @method('PATCH')
        @endif

        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $category->name)" required maxlength="50" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="slug" value="URL slug (optional)" />
            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full font-mono" :value="old('slug', $category->slug)" maxlength="60" aria-describedby="slug-help" />
            <p id="slug-help" class="mt-1 text-xs text-gray-500 dark:text-gray-400">Used in the address, e.g. /categories/<span class="font-mono">python</span>. Left blank, it's made from the name.</p>
            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="description" value="Description" />
            <x-textarea id="description" name="description" rows="4" class="mt-1 font-sans" required maxlength="500">{{ old('description', $category->description) }}</x-textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="icon" value="Icon" />
            <select id="icon" name="icon" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 dark:border-gray-700 dark:bg-gray-900">
                <option value="">None (show initials)</option>
                @foreach ($icons as $icon)
                    <option value="{{ $icon }}" @selected(old('icon', $category->icon) === $icon)>{{ $icon }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('icon')" class="mt-2" />
        </div>
        <div class="flex gap-3">
            <x-button>{{ $category->exists ? 'Save changes' : 'Create category' }}</x-button>
            <x-button :href="route('admin.categories.index')" variant="ghost">Cancel</x-button>
        </div>
    </form>
</x-admin-layout>
