<?php

use App\Http\Controllers\Api\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Project Routes
    Route::get('/projects/search', [ProjectController::class, 'search']);
    Route::get('/projects/{project}/documents', [ProjectController::class, 'documents']);
    Route::apiResource('projects', ProjectController::class);
});