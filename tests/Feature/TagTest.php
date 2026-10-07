<?php

use App\Models\Category;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;

test('threads can be posted with tags', function () {
    $category = Category::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('threads.store', $category), [
            'title' => 'How do I merge two DataFrames?',
            'body' => 'I have two frames with a shared id column.',
            'tags' => 'Pandas, #merge  pandas dataframe',
        ])
        ->assertSessionHasNoErrors();

    expect(Thread::sole()->tags->pluck('name')->all())->toBe(['dataframe', 'merge', 'pandas']);
});

test('tags are reused rather than duplicated', function () {
    Tag::factory()->create(['name' => 'python', 'slug' => 'python']);
    $category = Category::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('threads.store', $category), [
            'title' => 'Python list comprehension question',
            'body' => 'How do nested comprehensions work?',
            'tags' => 'python',
        ]);

    expect(Tag::count())->toBe(1);
});

test('tags with symbols get distinct url-safe slugs', function () {
    $category = Category::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('threads.store', $category), [
            'title' => 'Comparing C++, C and C# syntax',
            'body' => 'What are the main differences?',
            'tags' => 'c++ c c# .net cplusplus',
        ])
        ->assertSessionHasNoErrors();

    expect(Tag::orderBy('name')->pluck('slug', 'name')->all())->toBe([
        '.net' => 'dotnet',
        'c' => 'c',
        'c#' => 'csharp',
        'c++' => 'cplusplus',
        'cplusplus' => 'cplusplus-2',
    ]);

    $this->get('/tags/csharp')->assertOk()->assertSeeText('c#');
});

test('at most five tags are allowed', function () {
    $category = Category::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('threads.store', $category), [
            'title' => 'A question with far too many tags',
            'body' => 'This should be rejected.',
            'tags' => 'one two three four five six',
        ])
        ->assertSessionHasErrors('tag_names');

    expect(Thread::count())->toBe(0);
});

test('invalid tag names are rejected', function () {
    $category = Category::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('threads.store', $category), [
            'title' => 'A question with a bad tag',
            'body' => 'This should be rejected.',
            'tags' => 'ok <script>',
        ])
        ->assertSessionHasErrors('tag_names.1');

    expect(Tag::count())->toBe(0);
});

test('editing a thread replaces its tags', function () {
    $thread = Thread::factory()->create();
    $thread->tags()->attach(Tag::factory()->create(['name' => 'old', 'slug' => 'old']));

    $this->actingAs($thread->user)
        ->patch(route('threads.update', $thread), [
            'title' => $thread->title,
            'body' => $thread->body,
            'tags' => 'new',
        ])
        ->assertRedirect(route('threads.show', $thread));

    expect($thread->fresh()->tags->pluck('name')->all())->toBe(['new']);
});

test('edit form is prefilled with current tags', function () {
    $thread = Thread::factory()->create();
    $thread->tags()->attach([
        Tag::factory()->create(['name' => 'csv', 'slug' => 'csv'])->id,
        Tag::factory()->create(['name' => 'pandas', 'slug' => 'pandas'])->id,
    ]);

    $this->actingAs($thread->user)
        ->get(route('threads.edit', $thread))
        ->assertSee('value="csv, pandas"', false);
});

test('tag page lists only threads with that tag', function () {
    $tag = Tag::factory()->create(['name' => 'recursion', 'slug' => 'recursion']);
    $tagged = Thread::factory()->create(['title' => 'Tagged recursion question']);
    $tagged->tags()->attach($tag);
    Thread::factory()->create(['title' => 'Untagged question']);

    $this->get(route('tags.show', $tag))
        ->assertOk()
        ->assertSeeText('Tagged recursion question')
        ->assertDontSeeText('Untagged question');
});

test('tag index lists tags in use with counts', function () {
    $used = Tag::factory()->create(['name' => 'used', 'slug' => 'used']);
    Tag::factory()->create(['name' => 'unused', 'slug' => 'unused']);
    foreach (Thread::factory()->count(2)->create() as $thread) {
        $thread->tags()->attach($used);
    }

    $this->get(route('tags.index'))
        ->assertOk()
        ->assertSeeText('used')
        ->assertSeeText('2 questions')
        ->assertDontSeeText('unused');
});

test('thread rows and thread page show tag chips', function () {
    $thread = Thread::factory()->create();
    $thread->tags()->attach(Tag::factory()->create(['name' => 'arrays', 'slug' => 'arrays']));

    $this->get(route('home'))->assertSee(route('tags.show', 'arrays'), false);
    $this->get(route('threads.show', $thread))->assertSee(route('tags.show', 'arrays'), false);
});
