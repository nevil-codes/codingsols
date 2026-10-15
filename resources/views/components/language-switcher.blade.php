@props(['compact' => false])

@php
$current = app()->getLocale();
$languages = App\Support\Locale::supported();
$suggested = array_values(array_intersect(App\Support\Locale::suggested(request()), array_keys($languages)));
$others = array_values(array_diff(array_keys($languages), $suggested));
@endphp

@if ($compact)
    {{-- A plain select works without JavaScript; the button is hidden once Alpine loads. --}}
    <form method="POST" action="{{ route('locale.update') }}" {{ $attributes->merge(['class' => 'flex items-center gap-2']) }} x-data>
        @csrf
        <label for="language-{{ $attributes->get('id', 'compact') }}" class="sr-only">{{ __('Language') }}</label>
        <select id="language-{{ $attributes->get('id', 'compact') }}" name="locale" @change="$el.form.submit()"
            class="rounded-lg border-gray-200 bg-transparent py-1 pl-2 pr-8 text-sm text-gray-600 focus:border-accent-500 focus:ring-accent-500 dark:border-gray-800 dark:text-gray-300">
            @foreach ([...$suggested, ...$others] as $code)
                <option value="{{ $code }}" lang="{{ $code }}" @selected($code === $current)>{{ $languages[$code] }}</option>
            @endforeach
        </select>
        <button type="submit" x-show="false" class="text-sm underline">{{ __('Change') }}</button>
    </form>
@else
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button type="button" class="flex items-center gap-1 rounded-lg p-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                aria-label="{{ __('Language: :language', ['language' => $languages[$current]]) }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" /></svg>
                <span class="uppercase">{{ $current }}</span>
            </button>
        </x-slot>

        <x-slot name="content">
            <form method="POST" action="{{ route('locale.update') }}" class="py-1">
                @csrf
                @foreach ([$suggested, $others] as $group)
                    @if ($loop->last && $group !== [] && $suggested !== [])
                        <div class="my-1 border-t border-gray-100 dark:border-gray-700"></div>
                    @endif
                    @foreach ($group as $code)
                        <button type="submit" name="locale" value="{{ $code }}" lang="{{ $code }}" @if ($code === $current) aria-current="true" @endif
                            class="flex w-full items-center justify-between px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:text-gray-300 dark:hover:bg-gray-800 dark:focus:bg-gray-800">
                            {{ $languages[$code] }}
                            @if ($code === $current)
                                <svg class="h-4 w-4 text-accent-600 dark:text-accent-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 4.15a.75.75 0 0 1 .15 1.05l-8 10.5a.75.75 0 0 1-1.13.08l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.9 3.9 7.46-9.82a.75.75 0 0 1 1.06-.15Z" clip-rule="evenodd"/></svg>
                            @endif
                        </button>
                    @endforeach
                @endforeach
            </form>
        </x-slot>
    </x-dropdown>
@endif
