@props(['category'])

@php
$path = resource_path('icons/brands/'.basename((string) $category->icon).'.svg');
$svg = $category->icon && is_file($path)
    ? preg_replace(['/<title>.*?<\/title>/', '/<svg /'], ['', '<svg aria-hidden="true" fill="currentColor" class="h-6 w-6" '], file_get_contents($path))
    : null;
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:ring-gray-700']) }}>
    @if ($svg)
        {!! $svg !!}
    @else
        <span class="font-mono text-sm font-semibold" aria-hidden="true">{{ mb_substr($category->name, 0, 2) }}</span>
    @endif
</span>
