<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="Codingsols is a community forum where programmers ask questions, share answers and help each other level up.">

<title>{{ $title ? $title.' · ' : '' }}{{ config('app.name', 'Codingsols') }}</title>

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
