<?php

<<<<<<< HEAD
use app\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

=======
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\SkinAnalysisController;

// test route tanpa middleware
>>>>>>> 5c6469d (push kode awal)
Route::get('/auth-check', function (Request $request) {
    return response()->json([
        'message' => 'Authenticated!',
        'user' => $request->auth_user,
    ]);
})->middleware('firebase-auth');


// route yang butuh firebase auth seperti user
Route::middleware('firebase-auth')->group(function () {

//      Route::get('/profile', function (Request $request) {
//          return response()->json([
//              'message' => 'Token Valid!',
//              'uid' => $request->attributes->get('firebase_uid')
//          ]);
//      });
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::post('/profile/avatar', [UserController::class, 'uploadAvatar']);
<<<<<<< HEAD

});
=======
});

Route::middleware('firebase-auth')->group(function () {

    Route::post('/skin-analysis', [SkinAnalysisController::class, 'store']);
    Route::get('/skin-analysis/history', [SkinAnalysisController::class, 'history']);
    Route::get('/skin-analysis/{id}', [SkinAnalysisController::class, 'show']);
    

});


// ADMIN AUTH
Route::post('/admin/login', [AdminAuthController::class, 'login']); 
Route::middleware(['auth:sanctum', 'admin-only'])->group(function () {
    Route::get('/blogs', [BlogController::class, 'tampil']);
    Route::post('/blogs', [BlogController::class, 'tambah']);
    Route::put('/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogController::class, 'hapus']);
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

    //Admin mengelola akun user
    Route::get('/users', [AdminAuthController::class, 'index']);
    Route::delete('/users/{id}', [AdminAuthController::class, 'destroy']);
    
});

>>>>>>> 5c6469d (push kode awal)
