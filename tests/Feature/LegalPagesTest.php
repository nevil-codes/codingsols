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
    $this->get(route('legal.terms.de'))
        ->assertSee(route('legal.privacy.de'), false)
        ->assertDontSee('Deine Rechte');

    $this->get(route('legal.privacy.de'))->assertSee('Art. 15 DSGVO');
});

test('visitors in Germany get the German documents in the footer', function () {
    $this->withHeader('x-vercel-ip-country', 'DE')->get(route('home'))
        ->assertSee('href="'.route('legal.privacy.de').'"', false)
        ->assertSee('>Datenschutz<', false)
        ->assertSee('>Nutzungsbedingungen<', false);
});

test('visitors whose browser prefers German get the German documents', function () {
    $this->withHeader('Accept-Language', 'de-DE,de;q=0.9,en;q=0.8')->get(route('home'))
        ->assertSee('href="'.route('legal.privacy.de').'"', false);
});

test('other visitors get the English documents', function () {
    $this->withHeaders(['x-vercel-ip-country' => 'US', 'Accept-Language' => 'en-US'])->get(route('home'))
        ->assertSee('href="'.route('legal.privacy').'"', false)
        ->assertSee('>Privacy<', false)
        ->assertDontSee('>Datenschutz<', false);
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
