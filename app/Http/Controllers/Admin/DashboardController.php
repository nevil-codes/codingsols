<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Report;
use App\Models\Thread;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'Open reports' => [Report::open()->count(), route('admin.reports.index')],
                'Contact messages' => [ContactMessage::count(), route('admin.messages.index')],
                'Questions' => [Thread::count(), null],
                'Members' => [User::count(), null],
            ],
        ]);
    }
}
