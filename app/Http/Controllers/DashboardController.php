<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'threads' => $user->threads()->with('category')->withCount('comments')->latest()->get(),
            'comments' => $user->comments()->with('thread')->latest()->take(20)->get(),
        ]);
    }
}
