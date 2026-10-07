<x-admin-layout title="Overview">
    <dl class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($stats as $label => [$value, $link])
            <x-card class="p-5">
                <dt class="text-sm text-gray-600 dark:text-gray-400">{{ $label }}</dt>
                <dd class="mt-1 text-3xl font-semibold tabular-nums">
                    @if ($link)
                        <a href="{{ $link }}" class="hover:text-accent-600 dark:hover:text-accent-400">{{ number_format($value) }}</a>
                    @else
                        {{ number_format($value) }}
                    @endif
                </dd>
            </x-card>
        @endforeach
    </dl>
</x-admin-layout>
