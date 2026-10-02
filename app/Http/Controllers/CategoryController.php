<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        return view('categories.show', [
            'category' => $category,
            'threads' => $category->threads()
                ->with('user')
                ->withCount('comments')
                ->latest()
                ->paginate(15),
        ]);
    }
}
