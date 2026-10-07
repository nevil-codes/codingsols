<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class ThreadLockController extends Controller
{
    public function store(Thread $thread): RedirectResponse
    {
        Gate::authorize('lock', $thread);

        $thread->forceFill(['locked_at' => now()])->save();

        return redirect()->route('threads.show', $thread)->with('flash', 'Thread locked. No new replies or votes.');
    }

    public function destroy(Thread $thread): RedirectResponse
    {
        Gate::authorize('lock', $thread);

        $thread->forceFill(['locked_at' => null])->save();

        return redirect()->route('threads.show', $thread)->with('flash', 'Thread unlocked.');
    }
}
