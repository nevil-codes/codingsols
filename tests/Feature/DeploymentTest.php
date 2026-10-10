<?php

use App\Http\Middleware\BlockSpamBots;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\QueuedResetPassword;
use App\Notifications\QueuedVerifyEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

test('responses carry security headers', function () {
    $this->get(route('home'))
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
        ->assertHeaderMissing('Strict-Transport-Security');
});

test('HSTS is only sent over HTTPS', function () {
    $this->get('https://localhost/')->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
});

test('the health check responds', function () {
    $this->get('/up')->assertOk();
});

test('verification and password reset emails go through the queue', function () {
    Notification::fake();

    $this->post('/register', [...humanFormFields(), 'name' => 'Ada', 'email' => 'ada@example.com', 'password' => 'password', 'password_confirmation' => 'password']);
    Notification::assertSentTo(User::sole(), QueuedVerifyEmail::class);

    expect(new QueuedVerifyEmail)->toBeInstanceOf(ShouldQueue::class)
        ->and(new QueuedResetPassword('token'))->toBeInstanceOf(ShouldQueue::class);
});

test('housekeeping tasks are scheduled', function () {
    $commands = collect(app(Schedule::class)->events())->map->command->implode("\n");

    expect($commands)->toContain('auth:clear-resets')->toContain('queue:prune-failed');
});

describe('Cloudflare Turnstile', function () {
    beforeEach(function () {
        config(['services.turnstile.site_key' => 'site-key', 'services.turnstile.secret_key' => 'secret-key']);
    });

    $contact = fn (array $extra = []) => [...humanFormFields(), 'name' => 'Ada', 'email' => 'ada@example.com', 'message' => 'A perfectly normal message.', ...$extra];

    test('is off when no keys are configured', function () use ($contact) {
        config(['services.turnstile.site_key' => null, 'services.turnstile.secret_key' => null]);
        Http::fake();

        $this->get(route('contact'))->assertDontSee('cf-turnstile');
        $this->post(route('contact.store'), $contact())->assertSessionHasNoErrors();

        Http::assertNothingSent();
    });

    test('renders the widget when configured', function () {
        $this->get(route('contact'))
            ->assertSee('class="cf-turnstile" data-sitekey="site-key"', false)
            ->assertSee('challenges.cloudflare.com/turnstile/v0/api.js', false);
    });

    test('accepts a submission Cloudflare verifies', function () use ($contact) {
        Http::fake([BlockSpamBots::TURNSTILE_VERIFY_URL => Http::response(['success' => true])]);

        $this->post(route('contact.store'), $contact(['cf-turnstile-response' => 'good-token']))->assertSessionHasNoErrors();

        expect(ContactMessage::count())->toBe(1);
        Http::assertSent(fn ($request) => $request['secret'] === 'secret-key' && $request['response'] === 'good-token');
    });

    test('rejects a submission Cloudflare rejects', function () use ($contact) {
        Http::fake([BlockSpamBots::TURNSTILE_VERIFY_URL => Http::response(['success' => false])]);

        $this->post(route('contact.store'), $contact(['cf-turnstile-response' => 'bad-token']))->assertSessionHasErrors('form');

        expect(ContactMessage::count())->toBe(0);
    });

    test('rejects a submission without a token', function () use ($contact) {
        Http::fake();

        $this->post(route('contact.store'), $contact())->assertSessionHasErrors('form');

        expect(ContactMessage::count())->toBe(0);
        Http::assertNothingSent();
    });

    test('lets submissions through if Cloudflare is unreachable', function () use ($contact) {
        Http::fake(fn () => throw new ConnectionException('timed out'));

        $this->post(route('contact.store'), $contact(['cf-turnstile-response' => 'token']))->assertSessionHasNoErrors();

        expect(ContactMessage::count())->toBe(1);
    });
});

test('app:deploy migrates and seeds categories only once', function () {
    $this->artisan('app:deploy')->assertSuccessful();
    expect(Category::count())->toBe(8);

    Category::where('slug', 'python')->update(['name' => 'Python 3']);
    $this->artisan('app:deploy')->assertSuccessful();

    expect(Category::count())->toBe(8)
        ->and(Category::where('slug', 'python')->value('name'))->toBe('Python 3');
});

test('the Vercel entry point boots the app', function () {
    expect(file_get_contents(base_path('api/index.php')))->toContain("require __DIR__.'/../public/index.php'");

    $config = json_decode(file_get_contents(base_path('vercel.json')), true);
    expect($config['functions'])->toHaveKey('api/index.php')
        ->and($config['env']['QUEUE_CONNECTION'])->toBe('sync')
        ->and($config['env']['VIEW_COMPILED_PATH'])->toStartWith('/tmp');
});
