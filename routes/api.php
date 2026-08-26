<?php

use App\Models\Gleanable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('upload', [\App\Http\Controllers\Api\UploadController::class, 'upload']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('gleanables', function () {
        return Gleanable::select('id', 'name')->orderBy('name')->get();
    });
    Route::post('locations', [\App\Http\Controllers\Api\LocationController::class, 'store']);
});
