<?php

use App\Models\Gleanable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('upload', [\App\Http\Controllers\Api\UploadController::class, 'upload']);

// Eru agent — direct spot publishing
Route::middleware('eru.token')->prefix('eru')->group(function () {
    Route::get('gleanables', function () {
        return Gleanable::select('id', 'name')->orderBy('name')->get();
    });
    Route::post('spots', [\App\Http\Controllers\Api\Eru\SpotController::class, 'store']);
});
