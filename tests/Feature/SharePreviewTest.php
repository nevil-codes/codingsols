<?php

use App\Models\Category;
use App\Models\Thread;

test('pages have a description, canonical URL and share preview', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('<meta name="description" content="Codingsols is a community forum', false)
        ->assertSee('<link rel="canonical" href="'.route('home').'">', false)
        ->assertSee('<meta property="og:image" content="'.asset('og-image.png').'">', false)
        ->assertSee('<meta name="twitter:card" content="summary_large_image">', false);

    expect(public_path('og-image.png'))->toBeFile();
});

test('thread pages describe the question', function () {
    $thread = Thread::factory()->create(['title' => 'Why is my loop slow?', 'body' => "My **loop** takes forever.\n\n```php\nforeach (\$a as \$b) {}\n```"]);

    $this->get(route('threads.show', $thread))
        ->assertSee('<meta property="og:title" content="Why is my loop slow?">', false)
        ->assertSee('<meta name="description" content="My loop takes forever.', false);
});

test('category pages describe the category', function () {
    $category = Category::factory()->create(['name' => 'Rust']);

    $this->get(route('categories.show', $category))
        ->assertSee('<meta name="description" content="Rust questions and answers on Codingsols.', false);
});
