<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function thread(Request $request, Thread $thread): RedirectResponse
    {
        return $this->report($request, $thread, route('threads.show', $thread));
    }

    public function comment(Request $request, Comment $comment): RedirectResponse
    {
        return $this->report($request, $comment, route('threads.show', $comment->thread_id).'#reply-'.$comment->id);
    }

    /**
     * @param  Thread|Comment  $reportable
     */
    private function report(Request $request, Model $reportable, string $redirectTo): RedirectResponse
    {
        Gate::authorize('report', $reportable);

        $validated = $request->validate([
            'reason' => ['required', Rule::in(array_keys(Report::REASONS))],
            'details' => ['nullable', 'string', 'max:1000'],
        ]);

        // One report per person per post; reporting again updates it.
        $reportable->reports()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [...$validated, 'resolved_at' => null],
        );

        return redirect()->to($redirectTo)->with('flash', 'Thanks for the report. A moderator will take a look.');
    }
}
