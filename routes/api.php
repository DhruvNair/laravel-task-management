<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

//Open routes
Route::post('register', [AuthController::class, 'register'])->name('api.register');
Route::post('login', [AuthController::class, 'login'])->name('api.login');

//Protected routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('profile', [AuthController::class, 'profile'])->name('api.profile');
    Route::get('logout', [AuthController::class, 'logout'])->name('api.logout');
});

