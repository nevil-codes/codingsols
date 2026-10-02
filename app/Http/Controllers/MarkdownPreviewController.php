<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class MarkdownPreviewController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $validated = $request->validate(['body' => ['nullable', 'string', 'max:20000']]);

        $html = Str::markdown($validated['body'] ?? '', [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 20,
        ]);

        return response($html ?: '<p>Nothing to preview.</p>');
    }
}
