<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Thread $thread): RedirectResponse
    {
        $comment = $thread->comments()->make($request->validated());
        $comment->user()->associate($request->user());
        $comment->save();

        return redirect()
            ->to(route('threads.show', $thread).'#reply-'.$comment->id)
            ->with('flash', 'Your reply has been posted.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        Gate::authorize('delete', $comment);

        $thread = $comment->thread;
        $comment->delete();

        return redirect()->route('threads.show', $thread)->with('flash', 'Your reply has been deleted.');
    }
}
