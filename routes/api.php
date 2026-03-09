<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\RegisterController;

// test route tanpa middleware
Route::get('/auth-check', function (Request $request) {
    return response()->json([
        'message' => 'Authenticated!',
        'user' => $request->auth_user,
    ]);
})->middleware('firebase-auth');

Route::middleware('firebase-auth')->post(
    '/register',
    [RegisterController::class, 'register']
);
// route yang butuh firebase auth seperti user
Route::middleware('firebase-auth')->group(function () {
    
    Route::get('/blog', [BlogController::class, 'tampilUser']);

    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::post('/profile/avatar', [UserController::class, 'uploadAvatar']);
});

Route::middleware('firebase-auth')->group(function () {

    Route::post('/history', [HistoryController::class, 'store']);
    Route::get('/history', [HistoryController::class, 'index']);
    Route::delete('/history/{analyses_id}', [HistoryController::class, 'destroy']);
});

// ADMIN AUTH
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'admin-only'])->group(function () {
    Route::get('/blogs', [BlogController::class, 'tampil']);
    Route::post('/blogs', [BlogController::class, 'tambah']);
    Route::patch('/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogController::class, 'hapus']);
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

    //Admin mengelola akun user
    Route::get('/users', [AdminAuthController::class, 'index']);
    Route::delete('/users/{id}', [AdminAuthController::class, 'destroy']);
});