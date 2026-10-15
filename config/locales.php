<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supported languages
    |--------------------------------------------------------------------------
    |
    | Language code => name in that language, as shown in the language menu.
    | Each needs a lang/{code}.json file (English is the source language).
    |
    */

    'supported' => [
        'en' => 'English',
        'de' => 'Deutsch',
        'fr' => 'Français',
        'nl' => 'Nederlands',
        'es' => 'Español',
        'it' => 'Italiano',
        'pt' => 'Português',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default language by country
    |--------------------------------------------------------------------------
    |
    | Used when a visitor hasn't picked a language, based on the IP country
    | header from Vercel or Cloudflare. Countries with several languages
    | (Belgium, Switzerland, Luxembourg) are left out, so the browser's
    | language decides there.
    |
    */

    'countries' => [
        'DE' => 'de', 'AT' => 'de', 'LI' => 'de',
        'FR' => 'fr', 'MC' => 'fr',
        'NL' => 'nl', 'SR' => 'nl',
        'ES' => 'es', 'MX' => 'es', 'AR' => 'es', 'CO' => 'es', 'CL' => 'es', 'PE' => 'es', 'VE' => 'es',
        'EC' => 'es', 'GT' => 'es', 'CU' => 'es', 'BO' => 'es', 'DO' => 'es', 'HN' => 'es', 'PY' => 'es',
        'SV' => 'es', 'NI' => 'es', 'CR' => 'es', 'PA' => 'es', 'UY' => 'es', 'PR' => 'es',
        'IT' => 'it', 'SM' => 'it', 'VA' => 'it',
        'PT' => 'pt', 'BR' => 'pt', 'AO' => 'pt', 'MZ' => 'pt',
    ],

    /*
    | How long a language picked in the menu is remembered, in minutes.
    */

    'cookie_minutes' => 60 * 24 * 365,

];
