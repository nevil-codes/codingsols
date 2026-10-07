<?php

use App\Http\Middleware\BlockSpamBots;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

function contactForm(array $overrides = []): array
{
    return [...humanFormFields(), 'name' => 'Ada', 'email' => 'ada@example.com', 'message' => 'A perfectly normal message.', ...$overrides];
}

test('public forms include the spam trap fields', function () {
    $this->get(route('contact'))->assertSee('name="website"', false)->assertSee('name="form_started_at"', false);
    $this->get(route('register'))->assertSee('name="website"', false)->assertSee('name="form_started_at"', false);
});

test('filling the honeypot blocks the submission', function () {
    $this->post(route('contact.store'), contactForm(['website' => 'http://spam.example']))
        ->assertSessionHasErrors('form');

    expect(ContactMessage::count())->toBe(0);
});

test('submissions without a valid timestamp are blocked', function () {
    $this->post(route('contact.store'), contactForm(['form_started_at' => null]))->assertSessionHasErrors('form');
    $this->post(route('contact.store'), contactForm(['form_started_at' => '1700000000']))->assertSessionHasErrors('form');

    expect(ContactMessage::count())->toBe(0);
});

test('submissions faster than a person could type are blocked', function () {
    $this->post(route('contact.store'), contactForm([
        BlockSpamBots::TIMESTAMP_FIELD => Crypt::encryptString((string) now()->getTimestamp()),
    ]))->assertSessionHasErrors('form');

    expect(ContactMessage::count())->toBe(0);
});

test('bot registrations are blocked', function () {
    $this->post('/register', [
        'website' => 'spam',
        'form_started_at' => Crypt::encryptString((string) (now()->getTimestamp() - 5)),
        'name' => 'Bot',
        'email' => 'bot@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('form');

    expect(User::count())->toBe(0);
    $this->assertGuest();
});

test('registration is limited per IP address', function () {
    foreach (range(1, 5) as $i) {
        $this->post('/register', [...humanFormFields(), 'name' => "User {$i}", 'email' => "user{$i}@example.com", 'password' => 'password', 'password_confirmation' => 'password']);
        auth()->logout();
    }

    $this->post('/register', [...humanFormFields(), 'name' => 'User 6', 'email' => 'user6@example.com', 'password' => 'password', 'password_confirmation' => 'password'])
        ->assertTooManyRequests();
});

test('posting questions is rate limited per user', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    foreach (range(1, 5) as $i) {
        $this->actingAs($user)->post(route('threads.store', $category), ['title' => "Question number {$i} here", 'body' => 'Some details here.']);
    }

    $this->actingAs($user)
        ->post(route('threads.store', $category), ['title' => 'One question too many', 'body' => 'Some details here.'])
        ->assertTooManyRequests();
    expect(Thread::count())->toBe(5);

    // Another member is not affected.
    $this->actingAs(User::factory()->create())
        ->post(route('threads.store', $category), ['title' => 'A different member asks', 'body' => 'Some details here.'])
        ->assertRedirect();
});

test('posting replies is rate limited per user', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->create();

    foreach (range(1, 6) as $i) {
        $this->actingAs($user)->post(route('comments.store', $thread), ['body' => "Reply number {$i}"]);
    }

    $this->actingAs($user)->post(route('comments.store', $thread), ['body' => 'One too many'])->assertTooManyRequests();
    expect(Comment::count())->toBe(6);
});

test('links in posts are marked nofollow ugc', function () {
    $thread = Thread::factory()->create(['body' => 'Check out [my site](https://spam.example).']);

    $this->get(route('threads.show', $thread))
        ->assertSee('<a rel="nofollow ugc noopener" href="https://spam.example">my site</a>', false);
});
