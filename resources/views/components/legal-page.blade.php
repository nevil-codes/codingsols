@props(['lang', 'title', 'updated'])

@php
$updatedLabel = [
    'en' => 'Last updated:', 'de' => 'Stand:', 'fr' => 'Dernière mise à jour :', 'nl' => 'Laatst bijgewerkt:',
    'es' => 'Última actualización:', 'it' => 'Ultimo aggiornamento:', 'pt' => 'Última atualização:',
][$lang];
$document = request()->routeIs('legal.terms*') ? 'legal.terms' : 'legal.privacy';
@endphp

<x-app-layout :title="$title" :description="$title.' · Codingsols'">
    <article lang="{{ $lang }}" class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <header class="border-b border-gray-200 pb-6 dark:border-gray-800">
            <h1 class="text-3xl font-bold tracking-tight">{{ $title }}</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ $updatedLabel }}
                <time datetime="{{ $updated }}">{{ \Illuminate\Support\Carbon::parse($updated)->locale($lang)->isoFormat('LL') }}</time>
            </p>
            <nav class="mt-3 flex flex-wrap gap-x-3 gap-y-1 text-sm" aria-label="{{ __('Other languages') }}">
                @foreach (App\Support\Locale::supported() as $code => $name)
                    @if ($code === $lang)
                        <span class="font-medium text-gray-900 dark:text-white" aria-current="page" lang="{{ $code }}">{{ $name }}</span>
                    @else
                        <a href="{{ route($document, ['lang' => $code]) }}" hreflang="{{ $code }}" lang="{{ $code }}" class="text-accent-600 hover:underline dark:text-accent-400">{{ $name }}</a>
                    @endif
                @endforeach
            </nav>
        </header>

        <div class="prose prose-gray mt-8 max-w-none dark:prose-invert prose-headings:tracking-tight prose-a:text-accent-600 dark:prose-a:text-accent-400">
            {{ $slot }}
        </div>
    </article>
</x-app-layout>
