<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\UploadController;
use App\Models\Gleanable;
use Illuminate\Support\Facades\Route;

Route::post('upload', [UploadController::class, 'upload']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('gleanables', function () {
        return Gleanable::select('id', 'name')->orderBy('name')->get();
    });
    Route::get('locations', [LocationController::class, 'index']);
    Route::post('locations', [LocationController::class, 'store']);
});
