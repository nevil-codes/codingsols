@php($operator = config('legal.operator'))
@if ($operator['name'] && $operator['address'] && $operator['email'])
    <p>
        {{ $operator['name'] }}<br>
        @foreach ($operator['address'] as $line)
            {{ $line }}<br>
        @endforeach
        {{ $lang === 'de' ? 'E-Mail' : 'Email' }}: <a href="mailto:{{ $operator['email'] }}">{{ $operator['email'] }}</a>
    </p>
@else
    <p class="rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 text-amber-900 dark:border-amber-700 dark:bg-amber-950 dark:text-amber-200">
        {{ $lang === 'de'
            ? 'Die Angaben zum Betreiber fehlen noch (LEGAL_NAME, LEGAL_ADDRESS, LEGAL_EMAIL).'
            : 'Operator details have not been configured yet (LEGAL_NAME, LEGAL_ADDRESS, LEGAL_EMAIL).' }}
    </p>
@endif
