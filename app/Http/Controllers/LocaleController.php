<?php

namespace App\Http\Controllers;

use App\Support\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocaleController extends Controller
{
    /**
     * Switch the site language and remember the choice.
     */
    public function update(Request $request): RedirectResponse
    {
        $locale = $request->validate([
            'locale' => ['required', Rule::in(array_keys(Locale::supported()))],
        ])['locale'];

        $request->user()?->forceFill(['locale' => $locale])->save();

        return back()->withCookie(cookie(Locale::COOKIE, $locale, config('locales.cookie_minutes')));
    }
}
