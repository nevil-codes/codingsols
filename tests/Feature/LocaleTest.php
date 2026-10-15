<?php

use App\Models\Report;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReply;
use App\Support\Locale;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

test('the language follows the visitor\'s country', function (string $country, string $locale, string $text) {
    $this->withHeader('x-vercel-ip-country', $country)->get(route('home'))
        ->assertSee('<html lang="'.$locale.'">', false)
        ->assertSee($text);
})->with([
    ['DE', 'de', 'Neueste Fragen'],
    ['AT', 'de', 'Neueste Fragen'],
    ['FR', 'fr', 'Dernières questions'],
    ['NL', 'nl', 'Nieuwste vragen'],
    ['MX', 'es', 'Últimas preguntas'],
    ['IT', 'it', 'Ultime domande'],
    ['BR', 'pt', 'Perguntas mais recentes'],
    ['US', 'en', 'Latest questions'],
    ['JP', 'en', 'Latest questions'],
]);

test('Cloudflare\'s country header works too', function () {
    $this->withHeader('cf-ipcountry', 'FR')->get(route('home'))->assertSee('<html lang="fr">', false);
});

test('without a known country, the browser language decides', function () {
    $this->withHeader('Accept-Language', 'nl-BE,nl;q=0.9,fr;q=0.8')->get(route('home'))->assertSee('<html lang="nl">', false);
    $this->withHeader('Accept-Language', 'ja-JP,ja;q=0.9')->get(route('home'))->assertSee('<html lang="en">', false);
});

test('visitors can switch language, and the choice beats their country', function () {
    $this->withHeader('x-vercel-ip-country', 'DE')
        ->from(route('about'))
        ->post(route('locale.update'), ['locale' => 'es'])
        ->assertRedirect(route('about'))
        ->assertCookie(Locale::COOKIE, 'es');

    $this->withHeader('x-vercel-ip-country', 'DE')
        ->withCookie(Locale::COOKIE, 'es')
        ->get(route('home'))
        ->assertSee('<html lang="es">', false);
});

test('unsupported languages are rejected', function () {
    $this->post(route('locale.update'), ['locale' => 'ja'])->assertSessionHasErrors('locale');
});

test('a signed-in user\'s choice is saved to their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('locale.update'), ['locale' => 'it']);
    expect($user->fresh()->locale)->toBe('it');

    // Used on other devices, where there's no cookie yet.
    $this->actingAs($user->fresh())->get(route('home'))->assertSee('<html lang="it">', false);
});

test('new accounts remember the language they signed up in', function () {
    $this->withHeader('x-vercel-ip-country', 'FR')->post('/register', [
        ...humanFormFields(), 'name' => 'Ada', 'email' => 'ada@example.com',
        'password' => 'password', 'password_confirmation' => 'password', 'terms' => '1',
    ]);

    expect(User::sole()->locale)->toBe('fr');
});

test('reply emails are sent in the recipient\'s language', function () {
    Notification::fake();
    $thread = Thread::factory()->create(['title' => 'Boucle lente']);
    $thread->user->forceFill(['locale' => 'fr'])->save();

    $this->actingAs(User::factory()->create(['name' => 'Grace']))
        ->post(route('comments.store', $thread), ['body' => 'Essayez ceci.']);

    Notification::assertSentTo($thread->user, NewReply::class, function (NewReply $notification, array $channels, User $notifiable, string $locale) {
        app()->setLocale($locale);
        $mail = $notification->toMail($notifiable);

        return $locale === 'fr' && $mail->subject === 'Nouvelle réponse à « Boucle lente »';
    });
});

test('the language menu lists the local language and English first', function () {
    $html = $this->withHeader('x-vercel-ip-country', 'FR')->get(route('home'))->getContent();

    preg_match_all('/name="locale" value="(\w+)"/', $html, $matches);

    expect(array_slice($matches[1], 0, 2))->toBe(['fr', 'en'])
        ->and($matches[1])->toContain('de', 'nl', 'es', 'it', 'pt');
});

test('every string in the app is translated into every language', function () {
    $keys = collect([resource_path('views'), app_path()])
        ->flatMap(fn ($dir) => File::allFiles($dir))
        ->reject(fn ($file) => preg_match('#legal/(privacy|terms)-#', $file->getPathname()))
        ->flatMap(function ($file) {
            preg_match_all('/(?<![\w>])(?:__|trans_choice)\(\s*(\'(?:[^\'\\\\]|\\\\.)*\'|"(?:[^"\\\\]|\\\\.)*")/', $file->getContents(), $m);

            return array_map(fn ($literal) => stripcslashes(substr($literal, 1, -1)), $m[1]);
        })
        // Keys like "auth.password" live in the lang/{locale}/*.php files.
        ->reject(fn ($key) => preg_match('/^[a-z_]+\.[a-z_.]+$/', $key))
        ->merge(array_values(Thread::SORTS))
        ->merge(array_values(Report::REASONS))
        ->unique();

    foreach (array_keys(config('locales.supported')) as $locale) {
        if ($locale === 'en') {
            continue;
        }

        $translations = json_decode(File::get(lang_path("{$locale}.json")), true);
        $missing = $keys->reject(fn ($key) => array_key_exists($key, $translations))->values();

        expect($missing->all())->toBe([], "Missing {$locale} translations");
    }
});
