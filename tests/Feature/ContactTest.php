<?php

use App\Models\ContactMessage;

test('contact page is displayed', function () {
    $this->get(route('contact'))->assertOk();
});

test('contact messages are stored', function () {
    $this->post(route('contact.store'), [
        'name' => 'Ada',
        'email' => 'ada@example.com',
        'message' => 'Please add a Rust category.',
    ])->assertRedirect(route('contact'))->assertSessionHas('flash');

    expect(ContactMessage::sole())
        ->name->toBe('Ada')
        ->message->toBe('Please add a Rust category.');
});

test('contact messages are validated', function () {
    $this->post(route('contact.store'), ['name' => '', 'email' => 'not-an-email', 'message' => 'short'])
        ->assertSessionHasErrors(['name', 'email', 'message']);

    expect(ContactMessage::count())->toBe(0);
});

test('contact form is rate limited', function () {
    foreach (range(1, 5) as $i) {
        $this->post(route('contact.store'), ['name' => 'Bot', 'email' => 'bot@example.com', 'message' => "Message number {$i} here"]);
    }

    $this->post(route('contact.store'), ['name' => 'Bot', 'email' => 'bot@example.com', 'message' => 'One message too many'])
        ->assertTooManyRequests();
});
