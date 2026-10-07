<?php

use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Report;
use App\Models\Thread;
use App\Models\User;
use App\Models\Vote;

function makeAdmin(): User
{
    $user = User::factory()->create();
    $user->forceFill(['is_admin' => true])->save();

    return $user;
}

test('is_admin cannot be set through the profile form', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->patch('/profile', ['name' => 'Sneaky', 'email' => $user->email, 'is_admin' => true]);

    expect($user->fresh()->is_admin)->toBeFalse();
});

test('admin pages are only for admins', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->actingAs(User::factory()->create())->get(route('admin.dashboard'))->assertForbidden();
    $this->actingAs(makeAdmin())->get(route('admin.dashboard'))->assertOk();
});

test('every admin page renders', function () {
    $admin = makeAdmin();
    $thread = Thread::factory()->create();
    $thread->reports()->create(['user_id' => User::factory()->create()->id, 'reason' => 'spam']);
    ContactMessage::create(['name' => 'Ada', 'email' => 'ada@example.com', 'message' => 'Hello there, nice site.']);

    foreach (['admin.dashboard', 'admin.reports.index', 'admin.categories.index', 'admin.categories.create', 'admin.messages.index'] as $route) {
        $this->actingAs($admin)->get(route($route))->assertOk();
    }
    $this->actingAs($admin)->get(route('admin.categories.edit', $thread->category))->assertOk();
});

test('the admin link only shows for admins', function () {
    $this->actingAs(User::factory()->create())->get(route('home'))->assertDontSee(route('admin.dashboard'));
    $this->actingAs(makeAdmin())->get(route('home'))->assertSee(route('admin.dashboard'));
});

test('admins can delete any thread or reply but not edit them', function () {
    $thread = Thread::factory()->create();
    $comment = Comment::factory()->for($thread)->create();
    $admin = makeAdmin();

    $this->actingAs($admin)->get(route('threads.edit', $thread))->assertForbidden();
    $this->actingAs($admin)->delete(route('comments.destroy', $comment))->assertRedirect();
    $this->actingAs($admin)->delete(route('threads.destroy', $thread))->assertRedirect();

    expect(Thread::count())->toBe(0)->and(Comment::count())->toBe(0);
});

test('only admins can lock and unlock threads', function () {
    $thread = Thread::factory()->create();

    $this->actingAs($thread->user)->post(route('threads.lock', $thread))->assertForbidden();
    $this->actingAs(makeAdmin())->post(route('threads.lock', $thread));
    expect($thread->fresh()->isLocked())->toBeTrue();

    $this->actingAs(makeAdmin())->delete(route('threads.unlock', $thread));
    expect($thread->fresh()->isLocked())->toBeFalse();
});

test('locked threads block replies, votes, edits and accepting answers', function () {
    $thread = Thread::factory()->create();
    $comment = Comment::factory()->for($thread)->create();
    $thread->forceFill(['locked_at' => now()])->save();
    $member = User::factory()->create();

    $this->actingAs($member)->post(route('comments.store', $thread), ['body' => 'Too late'])->assertForbidden();
    $this->actingAs($member)->post(route('threads.vote', $thread), ['value' => 1])->assertForbidden();
    $this->actingAs($member)->post(route('comments.vote', $comment), ['value' => 1])->assertForbidden();
    $this->actingAs($thread->user)->get(route('threads.edit', $thread))->assertForbidden();
    $this->actingAs($thread->user)->post(route('threads.accept', [$thread, $comment]))->assertForbidden();

    expect(Comment::count())->toBe(1)->and(Vote::count())->toBe(0);

    $this->actingAs($member)->get(route('threads.show', $thread))
        ->assertSeeText('This question is locked')
        ->assertDontSee('Post answer');
});

test('users can report other people\'s posts once', function () {
    $thread = Thread::factory()->create();
    $reporter = User::factory()->create();

    $this->actingAs($reporter)->post(route('threads.report', $thread), ['reason' => 'spam'])->assertRedirect();
    $this->actingAs($reporter)->post(route('threads.report', $thread), ['reason' => 'offensive', 'details' => 'Rude']);

    expect(Report::count())->toBe(1)
        ->and(Report::sole()->reason)->toBe('offensive');
});

test('users cannot report their own posts', function () {
    $comment = Comment::factory()->create();

    $this->actingAs($comment->user)->post(route('comments.report', $comment), ['reason' => 'spam'])->assertForbidden();
});

test('report reasons are validated', function () {
    $thread = Thread::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('threads.report', $thread), ['reason' => 'because'])
        ->assertSessionHasErrors('reason');
});

test('admins can dismiss all open reports on a post', function () {
    $thread = Thread::factory()->create();
    $first = $thread->reports()->create(['user_id' => User::factory()->create()->id, 'reason' => 'spam']);
    $thread->reports()->create(['user_id' => User::factory()->create()->id, 'reason' => 'off-topic']);
    $admin = makeAdmin();

    $this->actingAs($admin)->post(route('admin.reports.dismiss', $first))->assertRedirect(route('admin.reports.index'));

    expect(Report::open()->count())->toBe(0)
        ->and(Report::first()->resolved_by)->toBe($admin->id);
});

test('admins can remove reported content, which clears its reports', function () {
    $comment = Comment::factory()->create();
    $report = $comment->reports()->create(['user_id' => User::factory()->create()->id, 'reason' => 'spam']);

    $this->actingAs(makeAdmin())->delete(route('admin.reports.remove', $report));

    expect(Comment::count())->toBe(0)->and(Report::count())->toBe(0);
});

test('deleting a thread removes votes and reports on it and its replies', function () {
    $thread = Thread::factory()->create();
    $comment = Comment::factory()->for($thread)->create();
    $member = User::factory()->create();
    $thread->vote($member, Vote::UP);
    $comment->vote($member, Vote::UP);
    $thread->reports()->create(['user_id' => $member->id, 'reason' => 'spam']);
    $comment->reports()->create(['user_id' => $member->id, 'reason' => 'spam']);

    $this->actingAs($thread->user)->delete(route('threads.destroy', $thread));

    expect(Vote::count())->toBe(0)->and(Report::count())->toBe(0);
});

test('admins can create, edit and delete categories', function () {
    $admin = makeAdmin();

    $this->actingAs($admin)->post(route('admin.categories.store'), [
        'name' => 'Rust Lang',
        'description' => 'Questions about the Rust programming language.',
        'icon' => '',
    ])->assertRedirect(route('admin.categories.index'));

    $category = Category::where('slug', 'rust-lang')->sole();

    $this->actingAs($admin)->patch(route('admin.categories.update', $category), [
        'name' => 'Rust',
        'slug' => 'rust',
        'description' => 'Questions about Rust.',
        'icon' => 'python',
    ])->assertRedirect();

    expect($category->fresh())->name->toBe('Rust')->slug->toBe('rust')->icon->toBe('python');

    $this->actingAs($admin)->delete(route('admin.categories.destroy', $category->fresh()));
    expect(Category::count())->toBe(0);
});

test('category slugs must be unique and icons must exist', function () {
    Category::factory()->create(['slug' => 'python']);

    $this->actingAs(makeAdmin())->post(route('admin.categories.store'), [
        'name' => 'Python',
        'description' => 'Duplicate',
        'icon' => '../../.env',
    ])->assertSessionHasErrors(['slug', 'icon']);
});

test('categories with questions cannot be deleted', function () {
    $thread = Thread::factory()->create();

    $this->actingAs(makeAdmin())->delete(route('admin.categories.destroy', $thread->category));

    expect(Category::count())->toBe(1)->and(Thread::count())->toBe(1);
});

test('admins can read and delete contact messages', function () {
    $message = ContactMessage::create(['name' => 'Ada', 'email' => 'ada@example.com', 'message' => 'Please add Rust.']);
    $admin = makeAdmin();

    $this->actingAs($admin)->get(route('admin.messages.index'))->assertSeeText('Please add Rust.');
    $this->actingAs($admin)->delete(route('admin.messages.destroy', $message));

    expect(ContactMessage::count())->toBe(0);
});

test('make-admin command grants and revokes admin rights', function () {
    $user = User::factory()->create(['email' => 'mod@example.com']);

    $this->artisan('app:make-admin', ['email' => 'mod@example.com'])->assertSuccessful();
    expect($user->fresh()->is_admin)->toBeTrue();

    $this->artisan('app:make-admin', ['email' => 'mod@example.com', '--revoke' => true])->assertSuccessful();
    expect($user->fresh()->is_admin)->toBeFalse();

    $this->artisan('app:make-admin', ['email' => 'missing@example.com'])->assertFailed();
});
