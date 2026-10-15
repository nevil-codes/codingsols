<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Operator
    |--------------------------------------------------------------------------
    |
    | The person or organisation responsible for the site ("Verantwortlicher"
    | under the GDPR). Shown in the privacy policy and terms. The address is
    | a single line with parts separated by "|", e.g. "Street 1|12345 City|Germany".
    |
    */

    'operator' => [
        'name' => env('LEGAL_NAME'),
        'address' => array_values(array_filter(array_map('trim', explode('|', (string) env('LEGAL_ADDRESS'))))),
        'email' => env('LEGAL_EMAIL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Where data is processed
    |--------------------------------------------------------------------------
    |
    | Update these if you move the database or change providers, so the
    | privacy policy stays accurate.
    |
    */

    'database_location' => [
        'en' => env('LEGAL_DATABASE_LOCATION_EN', 'the USA (Amazon Web Services, us-east-1)'),
        'de' => env('LEGAL_DATABASE_LOCATION_DE', 'den USA (Amazon Web Services, us-east-1)'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Versions
    |--------------------------------------------------------------------------
    |
    | Bump these when the documents change. The terms version is stored with
    | each account when the user accepts it at sign-up.
    |
    */

    'privacy_updated' => '2026-10-15',
    'terms_version' => '2026-10-15',

    /*
    |--------------------------------------------------------------------------
    | German-language visitors
    |--------------------------------------------------------------------------
    |
    | Visitors from these countries (by Vercel's or Cloudflare's IP country
    | header) are shown the German documents by default.
    |
    */

    'german_countries' => ['DE', 'AT', 'CH', 'LI'],

];
