<?php

use App\Models\Comment;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Support\Collection;

/**
 * @return Collection<int, SimpleXMLElement>
 */
function sitemapEntries(string $xml): Collection
{
    return collect(iterator_to_array(simplexml_load_string($xml)->url, false));
}

test('the sitemap lists categories, used tags and threads', function () {
    $thread = Thread::factory()->create();
    $used = Tag::factory()->create(['name' => 'used']);
    $thread->tags()->attach($used);
    $unused = Tag::factory()->create(['name' => 'unused']);

    $response = $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

    $urls = sitemapEntries($response->getContent())->map(fn ($url) => (string) $url->loc);

    expect($urls)->toContain(route('home'))
        ->toContain(route('categories.show', $thread->category))
        ->toContain(route('threads.show', $thread))
        ->toContain(route('tags.show', $used))
        ->not->toContain(route('tags.show', $unused));
});

test('a new reply updates the thread lastmod in the sitemap', function () {
    $thread = Thread::factory()->create(['updated_at' => now()->subWeek()]);
    $reply = Comment::factory()->for($thread)->create(['updated_at' => now()->subDay()]);

    $entry = sitemapEntries($this->get('/sitemap.xml')->getContent())->first(fn ($url) => (string) $url->loc === route('threads.show', $thread));

    expect((string) $entry->lastmod)->toBe($reply->updated_at->toAtomString());
});

test('robots.txt points to the sitemap and keeps crawlers out of private pages', function () {
    $this->get('/robots.txt')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee('Sitemap: '.route('sitemap'), false)
        ->assertSee('Disallow: /admin', false);
});

test('thread pages include QAPage structured data', function () {
    $thread = Thread::factory()->create(['title' => 'How do I sort a list?', 'body' => 'Use **sorted**.']);
    $answer = Comment::factory()->for($thread)->create(['body' => 'Call `sorted(items)`.']);
    Comment::factory()->for($thread)->create();
    $thread->acceptedAnswer()->associate($answer)->save();

    $html = $this->get(route('threads.show', $thread))->assertOk()->getContent();
    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $match);
    $data = json_decode($match[1], true);

    expect($data['@type'])->toBe('QAPage')
        ->and($data['mainEntity']['name'])->toBe('How do I sort a list?')
        ->and($data['mainEntity']['text'])->toBe('Use sorted.')
        ->and($data['mainEntity']['answerCount'])->toBe(2)
        ->and($data['mainEntity']['acceptedAnswer']['text'])->toBe('Call sorted(items).')
        ->and($data['mainEntity']['acceptedAnswer']['url'])->toBe(route('threads.show', $thread).'#reply-'.$answer->id)
        ->and($data['mainEntity']['suggestedAnswer'])->toHaveCount(1);
});

test('structured data cannot break out of its script tag', function () {
    $thread = Thread::factory()->create(['title' => 'Why does </script><script>alert(1)</script> appear?']);

    $html = $this->get(route('threads.show', $thread))->assertOk()->getContent();

    expect($html)->not->toContain('</script><script>alert(1)');
});
