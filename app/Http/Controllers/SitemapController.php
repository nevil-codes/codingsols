<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    /**
     * A sitemap can list at most 50,000 URLs.
     */
    private const MAX_THREADS = 45000;

    /**
     * List the public pages for search engines.
     */
    public function index(): Response
    {
        $threads = Thread::query()
            ->select(['id', 'updated_at'])
            ->withMax('comments', 'updated_at')
            ->latest('updated_at')
            ->limit(self::MAX_THREADS)
            ->get()
            // A new reply counts as a change to the page.
            ->each(fn (Thread $thread) => $thread->setAttribute('last_modified', max(
                $thread->updated_at,
                Carbon::parse($thread->comments_max_updated_at ?? $thread->updated_at),
            )));

        $urls = view('seo.sitemap', [
            'categories' => Category::query()->select(['id', 'slug', 'updated_at'])->orderBy('name')->get(),
            'tags' => Tag::query()->select(['id', 'slug', 'updated_at'])->has('threads')->orderBy('slug')->get(),
            'threads' => $threads,
        ])->render();

        // Added here rather than in the view: with short_open_tag enabled (as on
        // Vercel), a literal "<?xml" in a Blade file is parsed as PHP.
        return response('<?xml version="1.0" encoding="UTF-8"?>'."\n".$urls)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Keep crawlers out of private and duplicate pages, and point them at the sitemap.
     */
    public function robots(): Response
    {
        return response()
            ->view('seo.robots')
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
