<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category): View
    {
        $sort = in_array($request->query('sort'), array_keys(Thread::SORTS), true) ? $request->query('sort') : 'latest';

        return view('categories.show', [
            'category' => $category,
            'sort' => $sort,
            'threads' => $category->threads()
                ->with(['user', 'tags'])
                ->withCount('comments')
                ->sortBy($sort)
                ->paginate(15)
                ->withQueryString(),
        ]);
    }
}
