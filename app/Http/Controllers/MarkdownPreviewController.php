<?php

namespace App\Http\Controllers;

use App\Support\Markdown;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MarkdownPreviewController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $validated = $request->validate(['body' => ['nullable', 'string', 'max:20000']]);

        $html = Markdown::render($validated['body'] ?? '');

        return response($html ?: '<p>Nothing to preview.</p>');
    }
}
