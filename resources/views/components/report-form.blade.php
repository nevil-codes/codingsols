@props(['action', 'noun' => 'post'])

<details class="group relative">
    <summary class="cursor-pointer list-none text-xs text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Report</summary>
    <form method="POST" action="{{ $action }}"
        class="absolute right-0 z-20 mt-2 w-72 space-y-3 rounded-xl border border-gray-200 bg-white p-4 text-left shadow-lg dark:border-gray-800 dark:bg-gray-900">
        @csrf
        <fieldset>
            <legend class="text-sm font-semibold">Why are you reporting this {{ $noun }}?</legend>
            <div class="mt-2 space-y-1.5">
                @foreach (App\Models\Report::REASONS as $value => $label)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="reason" value="{{ $value }}" required class="text-accent-600 focus:ring-accent-500 dark:border-gray-600 dark:bg-gray-800">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </fieldset>
        <div>
            <label for="details-{{ md5($action) }}" class="text-xs text-gray-600 dark:text-gray-400">Details (optional)</label>
            <textarea id="details-{{ md5($action) }}" name="details" rows="2" maxlength="1000"
                class="mt-1 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-accent-500 focus:ring-accent-500 dark:border-gray-700 dark:bg-gray-950"></textarea>
        </div>
        <x-button size="sm" class="w-full">Send report</x-button>
    </form>
</details>
