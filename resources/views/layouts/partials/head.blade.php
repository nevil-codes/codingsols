<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
    $pageTitle = ($title ? $title.' · ' : '').config('app.name', 'Codingsols');
    $pageDescription = $description ?? __('Codingsols is a community forum where programmers ask questions, share answers and help each other level up.');
@endphp
<meta name="description" content="{{ $pageDescription }}">
<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('app.name', 'Codingsols') }}">
<meta property="og:title" content="{{ $title ?? config('app.name', 'Codingsols') }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('og-image.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ __('Codingsols: ask, answer, level up.') }}">
<meta name="twitter:card" content="summary_large_image">

<title>{{ $pageTitle }}</title>

@stack('head')

<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

<script>
    try {
        const theme = localStorage.getItem('theme');
        if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    } catch (e) {}
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
