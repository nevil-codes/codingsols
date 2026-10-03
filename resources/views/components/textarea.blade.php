@props(['disabled' => false])

<textarea @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-lg border-gray-300 bg-white font-mono text-sm shadow-sm focus:border-accent-500 focus:ring-accent-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100']) }}>{{ $slot }}</textarea>
