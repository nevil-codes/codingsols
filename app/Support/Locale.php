<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Decides which language to show a visitor.
 */
class Locale
{
    public const COOKIE = 'locale';

    /**
     * In order: the language picked in the menu, the one saved on the
     * account, the visitor's country, their browser's languages, English.
     */
    public static function for(Request $request): string
    {
        foreach ([$request->cookie(self::COOKIE), $request->user()?->locale, self::forCountry($request)] as $locale) {
            if (self::isSupported($locale)) {
                return $locale;
            }
        }

        return self::fromBrowser($request) ?? 'en';
    }

    /**
     * Languages to list first in the menu: the visitor's local one, then English.
     *
     * @return list<string>
     */
    public static function suggested(Request $request): array
    {
        return array_values(array_unique(array_filter([self::forCountry($request) ?? self::fromBrowser($request), 'en'])));
    }

    /**
     * @return array<string, string>
     */
    public static function supported(): array
    {
        return config('locales.supported');
    }

    public static function isSupported(mixed $locale): bool
    {
        return is_string($locale) && array_key_exists($locale, self::supported());
    }

    private static function forCountry(Request $request): ?string
    {
        $country = strtoupper((string) ($request->header('x-vercel-ip-country') ?? $request->header('cf-ipcountry')));

        return config('locales.countries')[$country] ?? null;
    }

    private static function fromBrowser(Request $request): ?string
    {
        foreach ($request->getLanguages() as $language) {
            $code = strtolower(substr($language, 0, 2));

            if (self::isSupported($code)) {
                return $code;
            }
        }

        return null;
    }
}
