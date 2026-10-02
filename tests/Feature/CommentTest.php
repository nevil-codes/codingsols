<?php

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;

test('guests cannot reply', function () {
    $thread = Thread::factory()->create();

    $this->post(route('comments.store', $thread), ['body' => 'A reply'])
        ->assertRedirect(route('login'));

    expect(Comment::count())->toBe(0);
});

test('verified users can reply as themselves', function () {
    $thread = Thread::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('comments.store', $thread), ['body' => 'Try `str[::-1]`.', 'user_id' => $thread->user_id])
        ->assertRedirect();

    $comment = Comment::sole();
    expect($comment->user_id)->toBe($user->id)
        ->and($comment->thread_id)->toBe($thread->id);

    $this->get(route('threads.show', $thread))->assertSee('<code>str[::-1]</code>', false);
});

test('reply body is required', function () {
    $thread = Thread::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('comments.store', $thread), ['body' => ''])
        ->assertSessionHasErrors('body');
});

test('only the author can delete a reply', function () {
    $comment = Comment::factory()->create();

    $this->actingAs(User::factory()->create())
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();

    $this->actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect(route('threads.show', $comment->thread));

    expect(Comment::count())->toBe(0);
});

test('markdown preview escapes raw html', function () {
    $this->actingAs(User::factory()->create())
        ->postJson(route('markdown.preview'), ['body' => '**bold** <img src=x onerror=alert(1)>'])
        ->assertOk()
        ->assertSee('<strong>bold</strong>', false)
        ->assertDontSee('<img', false);
});

test('dashboard shows the user activity', function () {
    $thread = Thread::factory()->create(['title' => 'My own question']);

    $this->actingAs($thread->user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('My own question');
});
