<?php

use App\Models\Thread;

test('excerpt strips markdown and html and limits length', function () {
    $thread = new Thread(['body' => "## Heading\n\nSome **bold** text <script>x</script> and `code`.\n\n".str_repeat('word ', 100)]);

    $excerpt = $thread->excerpt(60);

    expect($excerpt)
        ->toStartWith('Heading Some bold text')
        ->not->toContain('<')
        ->not->toContain('**')
        ->and(mb_strlen($excerpt))->toBeLessThanOrEqual(63);
});

test('excerpt decodes entities so the view escapes them only once', function () {
    $thread = new Thread(['body' => 'Calling `items.add("a")` on List<String>']);

    expect($thread->excerpt())->toBe('Calling items.add("a") on List');
});
