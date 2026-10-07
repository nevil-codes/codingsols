<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        return view('tags.index', [
            'tags' => Tag::whereHas('threads')
                ->withCount('threads')
                ->orderByDesc('threads_count')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(Tag $tag): View
    {
        return view('tags.show', [
            'tag' => $tag,
            'threads' => $tag->threads()
                ->with(['user', 'category', 'tags'])
                ->withCount('comments')
                ->latest()
                ->paginate(15),
        ]);
    }
}
