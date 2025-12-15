<?php

use app\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

});