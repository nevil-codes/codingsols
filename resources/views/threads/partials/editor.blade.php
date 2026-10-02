{{-- Markdown editor with Write / Preview tabs. Expects an Alpine scope with `tab` and `body`. --}}
<div class="rounded-xl border border-gray-300 bg-white shadow-sm focus-within:border-accent-500 focus-within:ring-1 focus-within:ring-accent-500 dark:border-gray-700 dark:bg-gray-900"
    x-init="$watch('tab', async (value) => {
        if (value !== 'preview') return;
        $refs.preview.innerHTML = '<p class=&quot;text-gray-500&quot;>Rendering…</p>';
        const response = await fetch('{{ route('markdown.preview') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'text/html', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
            body: JSON.stringify({ body }),
        });
        $refs.preview.innerHTML = response.ok ? await response.text() : '<p class=&quot;text-red-600&quot;>Preview failed.</p>';
        window.highlightCode($refs.preview);
    })">
    <div class="flex items-center gap-1 border-b border-gray-200 px-2 pt-2 dark:border-gray-800" role="tablist">
        <button type="button" role="tab" @click="tab = 'write'" :aria-selected="(tab === 'write').toString()"
            :class="tab === 'write' ? 'border-accent-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
            class="-mb-px border-b-2 px-3 py-2 text-sm font-medium">Write</button>
        <button type="button" role="tab" @click="tab = 'preview'" :aria-selected="(tab === 'preview').toString()"
            :class="tab === 'preview' ? 'border-accent-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
            class="-mb-px border-b-2 px-3 py-2 text-sm font-medium">Preview</button>
        <span class="ml-auto hidden pb-2 text-xs text-gray-400 sm:block">Markdown supported</span>
    </div>

    <div x-show="tab === 'write'">
        <label for="{{ $name }}" class="sr-only">{{ $label ?? 'Body' }}</label>
        <textarea id="{{ $name }}" name="{{ $name }}" x-model="body" rows="{{ $rows ?? 8 }}" required
            placeholder="{{ $placeholder }}"
            class="block w-full resize-y border-0 bg-transparent font-mono text-sm focus:ring-0"></textarea>
    </div>
    <div x-show="tab === 'preview'" x-cloak class="min-h-[10rem] p-4">
        <div x-ref="preview" class="prose prose-zinc prose-sm dark:prose-invert max-w-none"></div>
    </div>
</div>
<x-input-error :messages="$errors->get($name)" class="mt-2" />
