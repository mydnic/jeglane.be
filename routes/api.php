<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('upload', [\App\Http\Controllers\Api\UploadController::class, 'upload']);
