<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
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

    public function show(Thread $thread): View
    {
        $thread->load(['user', 'category', 'tags', 'comments' => fn ($query) => $query->with('user')->oldest()]);

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

        DB::transaction(function () use ($request, $thread) {
            $thread->update($request->threadAttributes());
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
