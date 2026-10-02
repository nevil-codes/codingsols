<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'categories' => Category::withCount('threads')->orderBy('id')->get(),
            'latestThreads' => Thread::with(['user', 'category'])
                ->withCount('comments')
                ->latest()
                ->take(8)
                ->get(),
        ]);
    }
}
