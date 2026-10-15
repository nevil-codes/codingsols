<?php

namespace App\Http\Controllers;

use App\Support\Locale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalController extends Controller
{
    public function privacy(Request $request): View
    {
        return $this->document('privacy', $this->language($request));
    }

    public function terms(Request $request): View
    {
        return $this->document('terms', $this->language($request));
    }

    /**
     * The German addresses (/datenschutz, /nutzungsbedingungen) always show German.
     */
    public function privacyGerman(): View
    {
        return $this->document('privacy', 'de');
    }

    public function termsGerman(): View
    {
        return $this->document('terms', 'de');
    }

    /**
     * ?lang=xx shows a specific language without changing the site language.
     */
    private function language(Request $request): string
    {
        return Locale::isSupported($request->query('lang')) ? $request->query('lang') : app()->getLocale();
    }

    private function document(string $document, string $language): View
    {
        return view("legal.{$document}-{$language}", ['document' => $document, 'language' => $language]);
    }
}
