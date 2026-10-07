@props(['current' => 'latest'])

<nav {{ $attributes->merge(['class' => 'inline-flex rounded-lg bg-gray-100 p-1 dark:bg-gray-800']) }} aria-label="Sort questions">
    @foreach (App\Models\Thread::SORTS as $key => $label)
        <a href="{{ request()->fullUrlWithQuery(['sort' => $key === 'latest' ? null : $key, 'page' => null]) }}"
            @class([
                'rounded-md px-3 py-1.5 text-sm font-medium transition-colors',
                'bg-white text-gray-900 shadow-sm dark:bg-gray-950 dark:text-white' => $current === $key,
                'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' => $current !== $key,
            ])
            @if ($current === $key) aria-current="page" @endif>{{ $label }}</a>
    @endforeach
</nav>
