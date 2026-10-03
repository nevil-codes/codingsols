@props(['href' => null])

@php
$classes = 'inline-flex items-center rounded-md bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes.' hover:bg-accent-50 hover:text-accent-700 hover:ring-accent-200 dark:hover:bg-accent-500/10 dark:hover:text-accent-300 dark:hover:ring-accent-500/30']) }}>{{ $slot }}</a>
@else
    <span {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</span>
@endif
