<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoteController extends Controller
{
    public function thread(Request $request, Thread $thread): RedirectResponse
    {
        return $this->cast($request, $thread, route('threads.show', $thread));
    }

    public function comment(Request $request, Comment $comment): RedirectResponse
    {
        return $this->cast($request, $comment, route('threads.show', $comment->thread_id).'#reply-'.$comment->id);
    }

    /**
     * @param  Thread|Comment  $votable
     */
    private function cast(Request $request, Model $votable, string $redirectTo): RedirectResponse
    {
        $validated = $request->validate([
            'value' => ['required', 'integer', Rule::in([Vote::UP, Vote::DOWN])],
        ]);

        abort_if($votable->user_id === $request->user()->id, 403, "You can't vote on your own posts.");

        $votable->vote($request->user(), (int) $validated['value']);

        return redirect()->to($redirectTo);
    }
}
