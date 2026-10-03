<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = trim((string) $request->string('q'));

        $threads = $query === ''
            ? null
            : Thread::with(['user', 'category'])
                ->withCount('comments')
                ->where(function ($builder) use ($query) {
                    $builder->whereLike('title', "%{$query}%")
                        ->orWhereLike('body', "%{$query}%");
                })
                ->latest()
                ->paginate(15)
                ->withQueryString();

        return view('search', ['query' => $query, 'threads' => $threads]);
    }
}
