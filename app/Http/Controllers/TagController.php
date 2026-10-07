<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Http\Request;
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

    public function show(Request $request, Tag $tag): View
    {
        $sort = in_array($request->query('sort'), array_keys(Thread::SORTS), true) ? $request->query('sort') : 'latest';

        return view('tags.show', [
            'tag' => $tag,
            'sort' => $sort,
            'threads' => $tag->threads()
                ->with(['user', 'category', 'tags'])
                ->withCount('comments')
                ->sortBy($sort)
                ->paginate(15)
                ->withQueryString(),
        ]);
    }
}
