<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;
use App\Search\DatabaseEngine;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        resolve(EngineManager::class)->extend('database', fn () => new DatabaseEngine);

        Gate::define('admin', fn (User $user) => $user->is_admin);

        $this->configureRateLimiting();

        // Store short, stable names instead of class names in polymorphic columns.
        Relation::enforceMorphMap([
            'thread' => Thread::class,
            'comment' => Comment::class,
            'user' => User::class,
        ]);
    }

    /**
     * Per-user limits for anything that creates content, per-IP for guests.
     */
    private function configureRateLimiting(): void
    {
        $key = fn (Request $request) => $request->user()?->id ?: $request->ip();

        RateLimiter::for('threads', fn (Request $request) => [
            Limit::perMinutes(10, 5)->by('threads:'.$key($request)),
            Limit::perDay(30)->by('threads-day:'.$key($request)),
        ]);
        RateLimiter::for('replies', fn (Request $request) => [
            Limit::perMinute(6)->by('replies:'.$key($request)),
            Limit::perHour(60)->by('replies-hour:'.$key($request)),
        ]);
        RateLimiter::for('votes', fn (Request $request) => Limit::perMinute(30)->by('votes:'.$key($request)));
        RateLimiter::for('reports', fn (Request $request) => Limit::perHour(20)->by('reports:'.$key($request)));
        RateLimiter::for('preview', fn (Request $request) => Limit::perMinute(60)->by('preview:'.$key($request)));
        RateLimiter::for('contact', fn (Request $request) => [
            Limit::perMinute(3)->by('contact:'.$request->ip()),
            Limit::perDay(20)->by('contact-day:'.$request->ip()),
        ]);
        RateLimiter::for('register', fn (Request $request) => Limit::perHour(5)->by('register:'.$request->ip()));
    }
}
