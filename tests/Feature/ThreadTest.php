<?php

use App\Models\Category;
use App\Models\Thread;
use App\Models\User;

test('home page lists categories and latest threads', function () {
    $thread = Thread::factory()->create(['title' => 'Why is my loop infinite?']);

    $this->get('/')
        ->assertOk()
        ->assertSee($thread->category->name)
        ->assertSee('Why is my loop infinite?');
});

test('category page lists its threads', function () {
    $category = Category::factory()->create();
    $mine = Thread::factory()->for($category)->create(['title' => 'Question in this category']);
    $other = Thread::factory()->create(['title' => 'Question somewhere else']);

    $this->get(route('categories.show', $category))
        ->assertOk()
        ->assertSee($mine->title)
        ->assertDontSee($other->title);
});

test('unknown category returns 404', function () {
    $this->get('/categories/does-not-exist')->assertNotFound();
});

test('guests cannot post threads', function () {
    $category = Category::factory()->create();

    $this->post(route('threads.store', $category), ['title' => 'A valid title here', 'body' => 'A valid body here'])
        ->assertRedirect(route('login'));

    expect(Thread::count())->toBe(0);
});

test('unverified users cannot post threads', function () {
    $user = User::factory()->unverified()->create();
    $category = Category::factory()->create();

    $this->actingAs($user)
        ->post(route('threads.store', $category), ['title' => 'A valid title here', 'body' => 'A valid body here'])
        ->assertRedirect(route('verification.notice'));

    expect(Thread::count())->toBe(0);
});

test('verified users can post threads as themselves', function () {
    $user = User::factory()->create();
    $someoneElse = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->post(route('threads.store', $category), [
        'title' => 'How do I reverse a string?',
        'body' => 'I tried a loop but it feels clumsy.',
        'user_id' => $someoneElse->id,
        'category_id' => 999,
    ]);

    $thread = Thread::sole();
    $response->assertRedirect(route('threads.show', $thread));
    expect($thread->user_id)->toBe($user->id)
        ->and($thread->category_id)->toBe($category->id);
});

test('thread input is validated', function () {
    $category = Category::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('threads.store', $category), ['title' => 'short', 'body' => ''])
        ->assertSessionHasErrors(['title', 'body']);
});

test('thread content is escaped and rendered as markdown', function () {
    $thread = Thread::factory()->create([
        'title' => '<script>alert("title")</script>',
        'body' => "Use `print()`\n\n<script>alert('body')</script>\n\n[click](javascript:alert(1))",
    ]);

    $response = $this->get(route('threads.show', $thread))->assertOk();

    $response->assertDontSee('<script>alert', false)
        ->assertDontSee('javascript:alert', false)
        ->assertSee('&lt;script&gt;alert', false)
        ->assertSee('<code>print()</code>', false);
});

test('authors can edit their threads', function () {
    $thread = Thread::factory()->create();

    $this->actingAs($thread->user)
        ->patch(route('threads.update', $thread), ['title' => 'An updated question title', 'body' => 'Updated body text'])
        ->assertRedirect(route('threads.show', $thread));

    expect($thread->fresh()->title)->toBe('An updated question title');
});

test('users cannot edit or delete threads they do not own', function () {
    $thread = Thread::factory()->create();
    $intruder = User::factory()->create();

    $this->actingAs($intruder)->get(route('threads.edit', $thread))->assertForbidden();
    $this->actingAs($intruder)
        ->patch(route('threads.update', $thread), ['title' => 'Hijacked question title', 'body' => 'Hijacked body'])
        ->assertForbidden();
    $this->actingAs($intruder)->delete(route('threads.destroy', $thread))->assertForbidden();

    expect($thread->fresh()->title)->not->toBe('Hijacked question title');
});

test('authors can delete their threads', function () {
    $thread = Thread::factory()->create();

    $this->actingAs($thread->user)
        ->delete(route('threads.destroy', $thread))
        ->assertRedirect(route('categories.show', $thread->category));

    expect(Thread::count())->toBe(0);
});

test('search finds threads by title and body', function () {
    Thread::factory()->create(['title' => 'Pandas merge question', 'body' => 'How do joins work?']);
    Thread::factory()->create(['title' => 'Unrelated', 'body' => 'Something about pointers']);

    $this->get(route('search', ['q' => 'pandas']))
        ->assertOk()
        ->assertSeeText('Pandas merge question')
        ->assertDontSeeText('Unrelated');

    $this->get(route('search', ['q' => 'pointers']))
        ->assertSeeText('Unrelated');
});

test('code blocks are keyboard focusable so they can be scrolled', function () {
    $thread = Thread::factory()->create(['body' => "```php\necho 'hi';\n```"]);

    $this->get(route('threads.show', $thread))->assertSee('<pre tabindex="0"><code class="language-php">', false);
});
