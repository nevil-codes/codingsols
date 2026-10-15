<?php

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReply;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

function replyTo(Thread $thread, User $as, string $body = 'Have you tried turning it off and on again?'): void
{
    test()->actingAs($as)->post(route('comments.store', $thread), ['body' => $body])->assertRedirect();
}

test('the author is notified in the app and by email when someone replies', function () {
    Notification::fake();
    $thread = Thread::factory()->create();
    $replier = User::factory()->create(['name' => 'Grace']);

    replyTo($thread, $replier);

    Notification::assertSentTo($thread->user, NewReply::class, function (NewReply $notification, array $channels) use ($thread) {
        $data = $notification->toArray($thread->user);

        return $channels === ['database', 'mail']
            && $data['thread_id'] === $thread->id
            && $data['replier_name'] === 'Grace'
            && $data['comment_id'] === Comment::sole()->id;
    });
});

test('replying to your own question sends nothing', function () {
    Notification::fake();
    $thread = Thread::factory()->create();

    replyTo($thread, $thread->user);

    Notification::assertNothingSent();
});

test('users who turned reply emails off only get the in-app notification', function () {
    Notification::fake();
    $thread = Thread::factory()->create();
    $thread->user->forceFill(['notify_replies' => false])->save();

    replyTo($thread, User::factory()->create());

    Notification::assertSentTo($thread->user, NewReply::class, fn ($notification, array $channels) => $channels === ['database']);
});

test('a busy thread sends at most one email per cooldown window', function () {
    Notification::fake();
    $thread = Thread::factory()->create();
    [$first, $second] = User::factory(2)->create();

    replyTo($thread, $first);
    replyTo($thread, $second, 'Another answer here.');

    $this->travel(NewReply::EMAIL_COOLDOWN_MINUTES + 1)->minutes();
    replyTo($thread, $first, 'A third answer.');

    // Check the channels recorded at send time; calling via() again would hit the cooldown.
    expect(Notification::sentNotifications()[User::class][$thread->user->id][NewReply::class])
        ->sequence(
            fn ($sent) => $sent->channels->toBe(['database', 'mail']),
            fn ($sent) => $sent->channels->toBe(['database']),
            fn ($sent) => $sent->channels->toBe(['database', 'mail']),
        );
});

test('the reply email shows user text literally', function () {
    $author = User::factory()->create();
    $thread = Thread::factory()->for($author)->create(['title' => 'Help [click](https://evil.test)']);
    $replier = User::factory()->create(['name' => 'Eve [x](https://evil.test)']);
    $comment = Comment::factory()->for($thread)->for($replier)->create(['body' => 'See [here](https://evil.test) for **details**.']);

    $html = (string) (new NewReply($comment))->toMail($author)->render();

    expect($html)->not->toContain('href="https://evil.test"')
        ->toContain('Help [click](https://evil.test)')
        ->toContain(route('threads.show', $thread).'#reply-'.$comment->id);
});

test('the notifications page lists replies, marks them read and clears the badge', function () {
    $thread = Thread::factory()->create(['title' => 'Why is my loop slow?']);
    replyTo($thread, User::factory()->create(['name' => 'Grace']));
    $author = $thread->user->fresh();

    $this->actingAs($author)->get(route('home'))->assertSee('Notifications (1 unread)');

    $this->get(route('notifications.index'))
        ->assertOk()
        ->assertSee('Grace')
        ->assertSee('Why is my loop slow?')
        ->assertSee('New:');

    expect($author->unreadNotifications()->count())->toBe(0);
    $this->get(route('home'))->assertDontSee('unread)');
});

test('notifications for deleted questions are not linked', function () {
    $thread = Thread::factory()->create(['title' => 'Soon to be gone']);
    replyTo($thread, User::factory()->create());
    $author = $thread->user;
    $thread->delete();

    $this->actingAs($author)->get(route('notifications.index'))
        ->assertSee('Soon to be gone')
        ->assertSee('(deleted)')
        ->assertDontSee(route('threads.show', $thread->id));
});

test('guests cannot see notifications', function () {
    $this->get(route('notifications.index'))->assertRedirect(route('login'));
});

test('users can turn reply emails off and on', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->patch(route('profile.notifications'))
        ->assertRedirect(route('profile.edit').'#notifications');
    expect($user->fresh()->notify_replies)->toBeFalse();

    $this->patch(route('profile.notifications'), ['notify_replies' => '1']);
    expect($user->fresh()->notify_replies)->toBeTrue();

    $this->get(route('profile.edit'))->assertSee('Email me when someone replies to my question');
});

test('deleting an account removes its notifications', function () {
    $thread = Thread::factory()->create();
    replyTo($thread, User::factory()->create());

    $thread->user->delete();

    expect(DB::table('notifications')->count())->toBe(0);
});
