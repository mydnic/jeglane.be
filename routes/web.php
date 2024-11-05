<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
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
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
});

Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
Route::get('locations/{gleaningLocation}', [LocationController::class, 'show'])->name('locations.show');

// Social Auth

Route::middleware('guest')->prefix('auth/social/{provider}')->group(function () {
    Route::get('redirect', [SocialController::class, 'redirect'])->name('social.redirect');
    Route::get('callback', [SocialController::class, 'callback'])->name('social.callback');
})->whereIn('category', config('fortify.social_providers'));
