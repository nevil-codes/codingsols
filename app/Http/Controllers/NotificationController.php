<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * List the user's notifications, newest first, and mark them as read.
     */
    public function index(Request $request): View
    {
        $notifications = $request->user()->notifications()->paginate(20);

        // Threads can be deleted after the notification was sent.
        $existingThreads = Thread::whereIn('id', $notifications->pluck('data.thread_id')->filter())->pluck('id');

        // The loaded models keep their unread state, so the page can still highlight what's new.
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return view('notifications.index', [
            'notifications' => $notifications,
            'existingThreads' => $existingThreads,
        ]);
    }
}
