<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlueprintController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\GeneratedPostController;
use App\Http\Controllers\Api\RawContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('blueprints', BlueprintController::class);
    Route::post('blueprints/{blueprint}/duplicate', [BlueprintController::class, 'duplicate']);

    Route::apiResource('raw-contents', RawContentController::class)->only([
        'index', 'store', 'show',
    ]);

    Route::post('raw-contents/{rawContent}/retry', [RawContentController::class, 'retry']);

    Route::get('generated-posts', [GeneratedPostController::class, 'index']);
    Route::get('generated-posts/{generatedPost}', [GeneratedPostController::class, 'show']);
    Route::patch('generated-posts/{generatedPost}/status', [GeneratedPostController::class, 'update']);

    Route::post('posts/{post}/chat', ChatController::class);
});

