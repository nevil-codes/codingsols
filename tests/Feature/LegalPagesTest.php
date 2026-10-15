<?php

use App\Models\User;

test('privacy policy and terms are available in English and German', function (string $route, string $heading) {
    $this->get(route($route))->assertOk()->assertSee($heading);
})->with([
    ['legal.privacy', 'Privacy Policy'],
    ['legal.privacy.de', 'Datenschutzerklärung'],
    ['legal.terms', 'Terms of Use'],
    ['legal.terms.de', 'Nutzungsbedingungen'],
]);

test('the privacy policy and terms are separate documents that link to each other', function () {
    $this->get(route('legal.terms', ['lang' => 'de']))
        ->assertSee(route('legal.privacy', ['lang' => 'de']), false)
        ->assertDontSee('Deine Rechte');

    $this->get(route('legal.privacy.de'))->assertSee('Art. 15 DSGVO');
});

test('both documents exist in every supported language', function () {
    foreach (array_keys(config('locales.supported')) as $code) {
        $this->get(route('legal.privacy', ['lang' => $code]))->assertOk()->assertSee('lang="'.$code.'"', false);
        $this->get(route('legal.terms', ['lang' => $code]))->assertOk()->assertSee('lang="'.$code.'"', false);
    }
});

test('legal pages follow the site language unless a language is requested', function () {
    $this->withHeader('x-vercel-ip-country', 'FR')->get(route('legal.privacy'))->assertSee('Politique de confidentialité');
    $this->withHeader('x-vercel-ip-country', 'FR')->get(route('legal.privacy', ['lang' => 'en']))->assertSee('Privacy Policy');
    $this->get(route('legal.terms.de'))->assertSee('Nutzungsbedingungen');
});

test('visitors in Germany see Datenschutz in the footer', function () {
    $this->withHeader('x-vercel-ip-country', 'DE')->get(route('home'))
        ->assertSee('href="'.route('legal.privacy').'"', false)
        ->assertSee('>Datenschutz<', false)
        ->assertSee('>Nutzungsbedingungen<', false);
});

test('operator details come from configuration', function () {
    config(['legal.operator' => ['name' => 'Jane Doe', 'address' => ['Musterstraße 1', '12345 Berlin'], 'email' => 'legal@example.com']]);

    $this->get(route('legal.privacy.de'))
        ->assertSee('Jane Doe')
        ->assertSee('Musterstraße 1')
        ->assertSee('mailto:legal@example.com', false)
        ->assertDontSee('LEGAL_NAME');
});

test('missing operator details are flagged', function () {
    config(['legal.operator' => ['name' => null, 'address' => [], 'email' => null]]);

    $this->get(route('legal.privacy'))->assertSee('Operator details have not been configured yet');
});

test('optional providers are only listed when enabled', function () {
    config(['services.turnstile.site_key' => null, 'sentry.dsn' => null]);
    $this->get(route('legal.privacy'))->assertDontSee('Cloudflare Turnstile')->assertDontSee('Sentry');

    config(['services.turnstile.site_key' => 'key', 'sentry.dsn' => 'https://key@sentry.example/1']);
    $this->get(route('legal.privacy'))->assertSee('Cloudflare Turnstile')->assertSee('Sentry');
});

test('sign-up requires accepting the terms and records it', function () {
    $fields = [...humanFormFields(), 'name' => 'Ada', 'email' => 'ada@example.com', 'password' => 'password', 'password_confirmation' => 'password'];

    $this->get('/register')
        ->assertSee('name="terms"', false)
        ->assertSee(route('legal.terms'), false)
        ->assertSee(route('legal.privacy'), false);

    $this->post('/register', $fields)->assertSessionHasErrors(['terms' => 'Please accept the Terms of Use to create an account.']);
    $this->assertGuest();

    $this->post('/register', [...$fields, 'terms' => '1']);

    $user = User::sole();
    expect($user->terms_accepted_at)->not->toBeNull()
        ->and($user->terms_version)->toBe(config('legal.terms_version'));
});
