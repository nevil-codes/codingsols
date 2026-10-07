<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class AcceptedAnswerController extends Controller
{
    public function store(Thread $thread, Comment $comment): RedirectResponse
    {
        Gate::authorize('acceptAnswer', $thread);
        abort_unless($comment->thread_id === $thread->id, 404);

        $thread->acceptedAnswer()->associate($comment)->save();

        return redirect()
            ->to(route('threads.show', $thread).'#reply-'.$comment->id)
            ->with('flash', 'Answer accepted.');
    }

    public function destroy(Thread $thread): RedirectResponse
    {
        Gate::authorize('acceptAnswer', $thread);

        $thread->acceptedAnswer()->dissociate()->save();

        return redirect()->route('threads.show', $thread)->with('flash', 'Accepted answer removed.');
    }
}
