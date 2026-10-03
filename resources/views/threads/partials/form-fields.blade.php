<div>
    <x-input-label for="title" value="Title" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $thread->title ?? '')" required autofocus maxlength="255"
        placeholder="e.g. How do I read a CSV file into a pandas DataFrame?" />
    <p class="mt-1 text-xs text-gray-500">Summarize the problem in one sentence.</p>
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div>
    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Details</span>
    <div class="mt-1">
        @include('threads.partials.editor', [
            'name' => 'body',
            'label' => 'Details',
            'rows' => 12,
            'placeholder' => "Describe the problem.\n\n```python\n# paste your code here\n```",
        ])
    </div>
</div>
