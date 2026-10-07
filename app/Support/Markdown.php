<?php

namespace App\Support;

use Illuminate\Support\Str;

class Markdown
{
    /**
     * Render user-written Markdown safely: raw HTML is escaped and unsafe
     * links removed. Code blocks get tabindex="0" so keyboard users can
     * scroll them when they overflow.
     */
    public static function render(?string $markdown): string
    {
        $html = Str::markdown((string) $markdown, [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 20,
        ]);

        return str_replace('<pre>', '<pre tabindex="0">', $html);
    }
}
