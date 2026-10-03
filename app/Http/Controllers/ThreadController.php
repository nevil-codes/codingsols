<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
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
        $thread = $category->threads()->make($request->validated());
        $thread->user()->associate($request->user());
        $thread->save();

        return redirect()->route('threads.show', $thread)->with('flash', 'Your question has been posted.');
    }

    public function show(Thread $thread): View
    {
        $thread->load(['user', 'category', 'comments' => fn ($query) => $query->with('user')->oldest()]);

        return view('threads.show', ['thread' => $thread]);
    }

    public function edit(Thread $thread): View
    {
        Gate::authorize('update', $thread);

        return view('threads.edit', ['thread' => $thread]);
    }

    public function update(StoreThreadRequest $request, Thread $thread): RedirectResponse
    {
        Gate::authorize('update', $thread);

        $thread->update($request->validated());

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
