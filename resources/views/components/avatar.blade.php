@props(['user', 'size' => 'md'])

@php
$palette = ['bg-indigo-500', 'bg-sky-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-violet-500', 'bg-teal-500', 'bg-fuchsia-500'];
$color = $palette[crc32((string) $user?->id) % count($palette)];
$initials = collect(explode(' ', trim($user?->name ?? '?')))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->join('');
$sizes = ['sm' => 'h-8 w-8 text-xs', 'md' => 'h-10 w-10 text-sm', 'lg' => 'h-14 w-14 text-lg'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex shrink-0 select-none items-center justify-center rounded-full font-semibold text-white {$color} {$sizes[$size]}"]) }} aria-hidden="true">
    {{ $initials ?: '?' }}
</span>
