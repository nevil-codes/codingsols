<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Report;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        // Group open reports by the post they're about, most reported first.
        $groups = Report::open()
            ->with(['user', 'reportable' => fn (MorphTo $morph) => $morph->morphWith([
                Thread::class => ['user', 'category'],
                Comment::class => ['user', 'thread'],
            ])])
            ->latest()
            ->limit(500)
            ->get()
            ->groupBy(fn (Report $report) => $report->reportable_type.':'.$report->reportable_id)
            ->sortByDesc(fn ($reports) => $reports->count());

        return view('admin.reports.index', ['groups' => $groups]);
    }

    /**
     * Close every open report on the same post without taking action.
     */
    public function dismiss(Request $request, Report $report): RedirectResponse
    {
        Report::open()
            ->where('reportable_type', $report->reportable_type)
            ->where('reportable_id', $report->reportable_id)
            ->update(['resolved_at' => now(), 'resolved_by' => $request->user()->id]);

        return redirect()->route('admin.reports.index')->with('flash', 'Reports dismissed.');
    }

    /**
     * Delete the reported post. Its reports are removed with it.
     */
    public function removeContent(Report $report): RedirectResponse
    {
        $report->reportable?->delete();

        return redirect()->route('admin.reports.index')->with('flash', 'Content removed.');
    }
}
