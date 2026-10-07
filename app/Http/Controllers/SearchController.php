<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Maximum number of matches taken from each index before merging.
     */
    private const MAX_MATCHES = 500;

    public function __invoke(Request $request): View
    {
        $query = trim((string) $request->string('q'));

        if ($query === '') {
            return view('search', ['query' => $query, 'threads' => null, 'replyMatches' => collect()]);
        }

        // Search threads and replies separately, then merge by thread. Using
        // keys keeps this working with any Scout driver (database, Meilisearch,
        // Typesense) since engines can't union across models themselves.
        $threadIds = Thread::search($query)->take(self::MAX_MATCHES)->keys();
        $replyThreadIds = Comment::search($query)->take(self::MAX_MATCHES)->get()->pluck('thread_id')->unique();

        $threads = Thread::with(['user', 'category', 'tags'])
            ->withCount('comments')
            ->whereIn('id', $threadIds->merge($replyThreadIds)->unique()->all())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('search', [
            'query' => $query,
            'threads' => $threads,
            'replyMatches' => $replyThreadIds->diff($threadIds)->flip(),
        ]);
    }
}
