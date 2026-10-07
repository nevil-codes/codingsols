<?php

namespace App\Support;

use Illuminate\Support\Str;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;

class Markdown
{
    /**
     * Render user-written Markdown safely: raw HTML is escaped and unsafe
     * links removed. Links get rel="nofollow ugc noopener" so spam gains no
     * search ranking, and code blocks get tabindex="0" so keyboard users
     * can scroll them when they overflow.
     */
    public static function render(?string $markdown): string
    {
        $html = Str::markdown((string) $markdown, [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 20,
            'external_link' => [
                'internal_hosts' => [parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'localhost'],
                'nofollow' => 'external',
                'noopener' => 'external',
                'noreferrer' => '',
                'html_class' => '',
            ],
        ], [new ExternalLinkExtension]);

        return str_replace(
            ['<pre>', 'rel="nofollow'],
            ['<pre tabindex="0">', 'rel="nofollow ugc'],
            $html,
        );
    }
}
