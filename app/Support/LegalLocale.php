<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Picks the language for the privacy policy and terms: German for visitors
 * in German-speaking countries or whose browser prefers German, English
 * otherwise. The rest of the site stays in English.
 */
class LegalLocale
{
    /**
     * Route names for each document and language.
     */
    private const ROUTES = [
        'privacy' => ['en' => 'legal.privacy', 'de' => 'legal.privacy.de'],
        'terms' => ['en' => 'legal.terms', 'de' => 'legal.terms.de'],
    ];

    private const LABELS = [
        'privacy' => ['en' => 'Privacy', 'de' => 'Datenschutz'],
        'terms' => ['en' => 'Terms', 'de' => 'Nutzungsbedingungen'],
    ];

    public static function for(Request $request): string
    {
        $country = strtoupper((string) ($request->header('x-vercel-ip-country') ?? $request->header('cf-ipcountry')));

        if (in_array($country, config('legal.german_countries'), true)) {
            return 'de';
        }

        return str_starts_with((string) $request->getPreferredLanguage(['en', 'de']), 'de') ? 'de' : 'en';
    }

    public static function url(string $document, ?string $locale = null): string
    {
        return route(self::ROUTES[$document][$locale ?? self::for(request())]);
    }

    public static function label(string $document, ?string $locale = null): string
    {
        return self::LABELS[$document][$locale ?? self::for(request())];
    }
}
