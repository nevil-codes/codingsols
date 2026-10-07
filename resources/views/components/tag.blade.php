@props(['tag'])

<a href="{{ route('tags.show', $tag) }}" {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md bg-accent-50 px-2 py-0.5 font-mono text-xs font-medium text-accent-700 ring-1 ring-inset ring-accent-200 hover:bg-accent-100 dark:bg-accent-500/10 dark:text-accent-300 dark:ring-accent-500/30 dark:hover:bg-accent-500/20']) }}>
    <span aria-hidden="true" class="opacity-60">#</span>{{ $tag->name }}
</a>
