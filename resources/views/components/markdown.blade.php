@props(['body'])

<div {{ $attributes->merge(['class' => 'prose prose-zinc dark:prose-invert max-w-none prose-a:text-accent-600 dark:prose-a:text-accent-400 prose-pre:rounded-lg']) }}>
    {!! Str::markdown($body, ['html_input' => 'escape', 'allow_unsafe_links' => false, 'max_nesting_level' => 20]) !!}
</div>
