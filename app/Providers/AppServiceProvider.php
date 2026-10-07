<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;
use App\Search\DatabaseEngine;
use Illuminate\Database\Eloquent\Relations\Relation;
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

        // Store short, stable names instead of class names in polymorphic columns.
        Relation::enforceMorphMap([
            'thread' => Thread::class,
            'comment' => Comment::class,
            'user' => User::class,
        ]);
    }
}
