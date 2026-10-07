<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ThreadController extends Controller
{
    public function create(Category $category): View
    {
        return view('threads.create', ['category' => $category]);
    }

    public function store(StoreThreadRequest $request, Category $category): RedirectResponse
    {
        $thread = DB::transaction(function () use ($request, $category) {
            $thread = $category->threads()->make($request->threadAttributes());
            $thread->user()->associate($request->user());
            $thread->save();
            $thread->tags()->sync(Tag::findOrCreateMany($request->validated('tag_names'))->modelKeys());

            return $thread;
        });

        return redirect()->route('threads.show', $thread)->with('flash', 'Your question has been posted.');
    }

    public function show(Request $request, Thread $thread): View
    {
        $thread->load(['user', 'category', 'tags', 'comments' => fn ($query) => $query->with('user')->oldest()]);

        // Accepted answer first, then highest score, then oldest.
        $comments = $thread->comments
            ->sortBy(fn (Comment $comment) => [$comment->id === $thread->accepted_comment_id ? 0 : 1, -$comment->score])
            ->values();

        return view('threads.show', [
            'thread' => $thread,
            'comments' => $comments,
            'myVotes' => $this->votesBy($request->user(), $thread),
        ]);
    }

    /**
     * The viewer's votes on this thread and its replies, keyed "type:id".
     *
     * @return array<string, int>
     */
    private function votesBy(?User $user, Thread $thread): array
    {
        if (! $user) {
            return [];
        }

        return Vote::where('user_id', $user->id)
            ->where(fn ($query) => $query
                ->where(fn ($q) => $q->where('votable_type', 'thread')->where('votable_id', $thread->id))
                ->orWhere(fn ($q) => $q->where('votable_type', 'comment')->whereIn('votable_id', $thread->comments->modelKeys())))
            ->get()
            ->mapWithKeys(fn (Vote $vote) => [$vote->votable_type.':'.$vote->votable_id => $vote->value])
            ->all();
    }

    public function edit(Thread $thread): View
    {
        Gate::authorize('update', $thread);

        return view('threads.edit', ['thread' => $thread]);
    }

    public function update(StoreThreadRequest $request, Thread $thread): RedirectResponse
    {
        Gate::authorize('update', $thread);

        DB::transaction(function () use ($request, $thread) {
            $thread->update([...$request->threadAttributes(), 'edited_at' => now()]);
            $thread->tags()->sync(Tag::findOrCreateMany($request->validated('tag_names'))->modelKeys());
        });

        return redirect()->route('threads.show', $thread)->with('flash', 'Your question has been updated.');
    }

    public function destroy(Thread $thread): RedirectResponse
    {
        Gate::authorize('delete', $thread);

        $category = $thread->category;
        $thread->delete();

        return redirect()->route('categories.show', $category)->with('flash', 'Your question has been deleted.');
    }
}
