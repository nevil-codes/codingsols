<?php

use App\Models\Category;
use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;
use App\Models\Vote;

test('guests cannot vote', function () {
    $thread = Thread::factory()->create();

    $this->post(route('threads.vote', $thread), ['value' => 1])->assertRedirect(route('login'));

    expect($thread->fresh()->score)->toBe(0);
});

test('users can upvote and downvote threads', function () {
    $thread = Thread::factory()->create();

    $this->actingAs(User::factory()->create())->post(route('threads.vote', $thread), ['value' => 1]);
    $this->actingAs(User::factory()->create())->post(route('threads.vote', $thread), ['value' => 1]);
    $this->actingAs(User::factory()->create())->post(route('threads.vote', $thread), ['value' => -1]);

    expect($thread->fresh()->score)->toBe(1)
        ->and(Vote::count())->toBe(3);
});

test('voting the same way twice removes the vote', function () {
    $thread = Thread::factory()->create();
    $voter = User::factory()->create();

    $this->actingAs($voter)->post(route('threads.vote', $thread), ['value' => 1]);
    $this->actingAs($voter)->post(route('threads.vote', $thread), ['value' => 1]);

    expect($thread->fresh()->score)->toBe(0)
        ->and(Vote::count())->toBe(0);
});

test('switching a vote moves the score by two', function () {
    $thread = Thread::factory()->create();
    $voter = User::factory()->create();

    $this->actingAs($voter)->post(route('threads.vote', $thread), ['value' => 1]);
    $this->actingAs($voter)->post(route('threads.vote', $thread), ['value' => -1]);

    expect($thread->fresh()->score)->toBe(-1)
        ->and(Vote::sole()->value)->toBe(-1);
});

test('users cannot vote on their own posts', function () {
    $thread = Thread::factory()->create();
    $comment = Comment::factory()->create();

    $this->actingAs($thread->user)->post(route('threads.vote', $thread), ['value' => 1])->assertForbidden();
    $this->actingAs($comment->user)->post(route('comments.vote', $comment), ['value' => 1])->assertForbidden();

    expect(Vote::count())->toBe(0);
});

test('only up or down votes are accepted', function () {
    $thread = Thread::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('threads.vote', $thread), ['value' => 5])
        ->assertSessionHasErrors('value');

    expect($thread->fresh()->score)->toBe(0);
});

test('replies can be voted on', function () {
    $comment = Comment::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('comments.vote', $comment), ['value' => 1])
        ->assertRedirect(route('threads.show', $comment->thread_id).'#reply-'.$comment->id);

    expect($comment->fresh()->score)->toBe(1);
});

test('voting does not mark a thread as edited or change updated_at', function () {
    $thread = Thread::factory()->create(['updated_at' => now()->subDay()]);
    $before = $thread->fresh()->updated_at;

    $this->actingAs(User::factory()->create())->post(route('threads.vote', $thread), ['value' => 1]);

    expect($thread->fresh()->updated_at->equalTo($before))->toBeTrue()
        ->and($thread->fresh()->edited_at)->toBeNull();
});

test('the thread page shows the viewer their current vote', function () {
    $thread = Thread::factory()->create();
    $voter = User::factory()->create();
    $thread->vote($voter, Vote::DOWN);

    $this->actingAs($voter)
        ->get(route('threads.show', $thread))
        ->assertSee('aria-pressed="true" aria-label="Downvote this question"', false)
        ->assertSee('aria-pressed="false" aria-label="Upvote this question"', false);
});

test('the author can accept and unaccept an answer', function () {
    $thread = Thread::factory()->create();
    $comment = Comment::factory()->for($thread)->create();

    $this->actingAs($thread->user)->post(route('threads.accept', [$thread, $comment]));
    expect($thread->fresh()->accepted_comment_id)->toBe($comment->id);

    $this->actingAs($thread->user)->delete(route('threads.unaccept', $thread));
    expect($thread->fresh()->accepted_comment_id)->toBeNull();
});

test('other users cannot accept answers', function () {
    $thread = Thread::factory()->create();
    $comment = Comment::factory()->for($thread)->create();

    $this->actingAs($comment->user)
        ->post(route('threads.accept', [$thread, $comment]))
        ->assertForbidden();

    expect($thread->fresh()->accepted_comment_id)->toBeNull();
});

test('a reply from another thread cannot be accepted', function () {
    $thread = Thread::factory()->create();
    $otherReply = Comment::factory()->create();

    $this->actingAs($thread->user)
        ->post(route('threads.accept', [$thread, $otherReply]))
        ->assertNotFound();
});

test('accepting an answer does not mark the thread as edited', function () {
    $thread = Thread::factory()->create();
    $comment = Comment::factory()->for($thread)->create();

    $this->actingAs($thread->user)->post(route('threads.accept', [$thread, $comment]));

    expect($thread->fresh()->edited_at)->toBeNull();
    $this->get(route('threads.show', $thread))->assertDontSeeText('edited');
});

test('editing a thread marks it as edited', function () {
    $thread = Thread::factory()->create();

    $this->actingAs($thread->user)->patch(route('threads.update', $thread), [
        'title' => 'An updated question title',
        'body' => 'Updated body text',
    ]);

    expect($thread->fresh()->edited_at)->not->toBeNull();
    $this->get(route('threads.show', $thread))->assertSeeText('edited');
});

test('deleting the accepted reply clears the accepted answer', function () {
    $thread = Thread::factory()->create();
    $comment = Comment::factory()->for($thread)->create();
    $thread->acceptedAnswer()->associate($comment)->save();

    $this->actingAs($comment->user)->delete(route('comments.destroy', $comment));

    expect($thread->fresh()->accepted_comment_id)->toBeNull();
});

test('replies are ordered accepted first, then by score, then oldest', function () {
    $thread = Thread::factory()->create();
    $old = Comment::factory()->for($thread)->create(['body' => 'Oldest reply', 'created_at' => now()->subHours(3)]);
    $top = Comment::factory()->for($thread)->create(['body' => 'Top voted reply', 'created_at' => now()->subHours(2)]);
    $accepted = Comment::factory()->for($thread)->create(['body' => 'Accepted reply', 'created_at' => now()->subHour()]);
    $top->vote(User::factory()->create(), Vote::UP);
    $thread->acceptedAnswer()->associate($accepted)->save();

    $this->get(route('threads.show', $thread))
        ->assertSeeTextInOrder(['Accepted reply', 'Top voted reply', 'Oldest reply']);
});

test('category questions can be sorted by top score and unanswered', function () {
    $category = Category::factory()->create();
    $low = Thread::factory()->for($category)->create(['title' => 'Low scoring question', 'created_at' => now()]);
    $high = Thread::factory()->for($category)->create(['title' => 'High scoring question', 'created_at' => now()->subDay()]);
    $high->vote(User::factory()->create(), Vote::UP);
    Comment::factory()->for($high)->create();

    $this->get(route('categories.show', $category))
        ->assertSeeTextInOrder(['Low scoring question', 'High scoring question']);

    $this->get(route('categories.show', [$category, 'sort' => 'top']))
        ->assertSeeTextInOrder(['High scoring question', 'Low scoring question']);

    $this->get(route('categories.show', [$category, 'sort' => 'unanswered']))
        ->assertSeeText('Low scoring question')
        ->assertDontSeeText('High scoring question');
});

test('invalid sort values fall back to latest', function () {
    $category = Category::factory()->create();

    $this->get(route('categories.show', [$category, 'sort' => 'bogus']))->assertOk();
    $this->get(route('categories.show', $category).'?sort[]=x')->assertOk();
});
