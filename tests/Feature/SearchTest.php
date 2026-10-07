<?php

use App\Models\Comment;
use App\Models\Thread;

test('search page loads without a query', function () {
    $this->get(route('search'))->assertOk()->assertSee('Type a keyword');
});

test('search matches every word, in any order, across title and body', function () {
    Thread::factory()->create(['title' => 'How do I read a CSV file?', 'body' => 'Using pandas in Python.']);
    Thread::factory()->create(['title' => 'CSV export in Excel', 'body' => 'No Python here.']);

    $this->get(route('search', ['q' => 'pandas csv']))
        ->assertOk()
        ->assertSee('How do I read a')
        ->assertDontSee('CSV export in Excel');
});

test('search is case insensitive', function () {
    Thread::factory()->create(['title' => 'Segmentation fault in C++']);

    $this->get(route('search', ['q' => 'SEGMENTATION']))->assertSee('fault in C++');
});

test('search finds threads through their replies', function () {
    $thread = Thread::factory()->create(['title' => 'My loop never ends', 'body' => 'Help please']);
    Comment::factory()->for($thread)->create(['body' => 'You forgot to increment the counter.']);

    $this->get(route('search', ['q' => 'increment counter']))
        ->assertOk()
        ->assertSee('My loop never ends')
        ->assertSee('Matched in a reply');
});

test('threads matching directly are not labelled as reply matches', function () {
    $thread = Thread::factory()->create(['title' => 'Recursion question', 'body' => 'What is recursion?']);
    Comment::factory()->for($thread)->create(['body' => 'Recursion is a function calling itself.']);

    $this->get(route('search', ['q' => 'recursion']))
        ->assertSeeText('Recursion question')
        ->assertDontSeeText('Matched in a reply');
});

test('search terms are highlighted without allowing html injection', function () {
    Thread::factory()->create(['title' => 'Escaping <b>tags</b> in output', 'body' => 'Body text']);

    $response = $this->get(route('search', ['q' => 'tags']))->assertOk();

    $response->assertSee('&lt;b&gt;<mark', false)
        ->assertSee('>tags</mark>&lt;/b&gt;', false)
        ->assertDontSee('<b>tags</b>', false);
});

test('one search term never matches inside markup added for another', function () {
    Thread::factory()->create(['title' => 'Rounded corners with css bg images', 'body' => 'Body text']);

    $response = $this->get(route('search', ['q' => 'css bg rounded']))->assertOk();

    $response->assertSee('<mark class="rounded-sm bg-amber-200/70', false)
        ->assertDontSee('<mark class="<mark', false)
        ->assertDontSee('-<mark', false);
});

test('search shows an empty state when nothing matches', function () {
    Thread::factory()->create(['title' => 'Something else entirely']);

    $this->get(route('search', ['q' => 'kubernetes']))->assertOk()->assertSee('No results');
});
