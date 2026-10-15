<?php

use App\Models\Thread;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\StarterContentSeeder;

beforeEach(fn () => $this->seed(CategorySeeder::class));

test('it adds answered starter questions from a team account', function () {
    $this->seed(StarterContentSeeder::class);

    $team = User::where('email', StarterContentSeeder::AUTHOR_EMAIL)->sole();

    expect(Thread::count())->toBe(10)
        ->and(Thread::whereNull('accepted_comment_id')->exists())->toBeFalse()
        ->and(Thread::where('user_id', '!=', $team->id)->exists())->toBeFalse()
        ->and($team->name)->toBe('Codingsols Team')
        ->and($team->is_admin)->toBeFalse()
        ->and($team->hasVerifiedEmail())->toBeTrue();

    $thread = Thread::where('title', 'like', '%list and a tuple%')->sole();
    $this->get(route('threads.show', $thread))
        ->assertOk()
        ->assertSee('<code class="language-python">', false)
        ->assertSee('Accepted answer');
});

test('it does nothing when questions already exist', function () {
    $existing = Thread::factory()->create();

    $this->seed(StarterContentSeeder::class);

    expect(Thread::sole()->is($existing))->toBeTrue()
        ->and(User::where('email', StarterContentSeeder::AUTHOR_EMAIL)->exists())->toBeFalse();
});
