<?php

use App\Http\Controllers\AcceptedAnswerController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarkdownPreviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ThreadLockController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::view('/about', 'about')->name('about');
Route::get('/search', SearchController::class)->name('search');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware(['throttle:contact', 'honeypot'])->name('contact.store');

Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::post('/markdown/preview', MarkdownPreviewController::class)->middleware('throttle:preview')->name('markdown.preview');

    Route::post('/categories/{category}/threads', [ThreadController::class, 'store'])->middleware('throttle:threads')->name('threads.store');
    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])->middleware('throttle:replies')->name('comments.store');

    Route::middleware('throttle:votes')->group(function () {
        Route::post('/threads/{thread}/vote', [VoteController::class, 'thread'])->name('threads.vote');
        Route::post('/comments/{comment}/vote', [VoteController::class, 'comment'])->name('comments.vote');
    });

    Route::middleware('throttle:reports')->group(function () {
        Route::post('/threads/{thread}/report', [ReportController::class, 'thread'])->name('threads.report');
        Route::post('/comments/{comment}/report', [ReportController::class, 'comment'])->name('comments.report');
    });

    Route::post('/threads/{thread}/lock', [ThreadLockController::class, 'store'])->name('threads.lock');
    Route::delete('/threads/{thread}/lock', [ThreadLockController::class, 'destroy'])->name('threads.unlock');

    Route::post('/threads/{thread}/accept/{comment}', [AcceptedAnswerController::class, 'store'])->name('threads.accept');
    Route::delete('/threads/{thread}/accept', [AcceptedAnswerController::class, 'destroy'])->name('threads.unaccept');

    Route::get('/categories/{category}/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::patch('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::middleware(['auth', 'verified', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');
    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/{report}/dismiss', [Admin\ReportController::class, 'dismiss'])->name('reports.dismiss');
    Route::delete('/reports/{report}/content', [Admin\ReportController::class, 'removeContent'])->name('reports.remove');
    Route::resource('categories', Admin\CategoryController::class)->except('show');
    Route::get('/messages', [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::delete('/messages/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
