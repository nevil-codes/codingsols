<x-card {{ $attributes->merge(['class' => 'p-5']) }}>
    <details class="group" open>
        <summary class="flex cursor-pointer list-none items-center justify-between text-sm font-semibold">
            Forum rules
            <svg class="h-4 w-4 text-gray-400 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
        </summary>
        <ul class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-400">
            <li>Search before asking. Someone may have solved it already.</li>
            <li>Include code, the full error message and what you tried.</li>
            <li>No spam, advertising or self-promotion.</li>
            <li>Don't post copyrighted or offensive material.</li>
            <li>Be respectful. Everyone was a beginner once.</li>
        </ul>
    </details>
</x-card>
