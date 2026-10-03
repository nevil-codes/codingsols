@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-sm font-medium text-gray-900 dark:text-white'
            : 'text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} @if ($active ?? false) aria-current="page" @endif>
    {{ $slot }}
</a>
