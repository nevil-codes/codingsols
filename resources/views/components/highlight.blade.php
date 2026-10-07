@props(['text', 'terms' => []])

@php
// Escape first, then wrap matches in <mark> in a single pass, so one term
// can never match inside markup added for another. The lookahead skips
// matches inside HTML entities such as &amp;.
$html = e($text);
if ($terms !== []) {
    $pattern = collect($terms)->map(fn ($term) => preg_quote(e($term), '/'))->sortByDesc(fn ($term) => mb_strlen($term))->join('|');
    $html = preg_replace(
        '/('.$pattern.')(?![^&\s]*;)/iu',
        '<mark class="rounded-sm bg-amber-200/70 px-0.5 text-gray-900 dark:bg-amber-400/30 dark:text-white">$1</mark>',
        $html,
    );
}
@endphp

{!! $html !!}
