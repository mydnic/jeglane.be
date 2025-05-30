<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\VoteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Jetstream\Http\Controllers\Inertia\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Inertia\TermsOfServiceController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/a-propos', [HomeController::class, 'about'])->name('about');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store')->middleware('optimizeImages');
    Route::post('/locations/{gleaningLocation}/vote', [VoteController::class, 'vote'])->name('locations.vote');
    Route::post('/locations/{gleaningLocation}/comments', [CommentController::class, 'store'])->name('locations.comments.store');
    Route::delete('/locations/{gleaningLocation}/comments/{comment}', [CommentController::class, 'destroy'])->name('locations.comments.destroy');
});

Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
Route::get('locations/{gleaningLocation}', [LocationController::class, 'show'])->name('locations.show');

Route::get('changelog', [ChangelogController::class, 'index'])->name('changelog.index');

// Social Auth
Route::middleware('guest')->prefix('auth/social/{provider}')->group(function () {
    Route::get('redirect', [SocialController::class, 'redirect'])->name('social.redirect');
    Route::get('callback', [SocialController::class, 'callback'])->name('social.callback');
})->whereIn('category', config('fortify.social_providers'));
