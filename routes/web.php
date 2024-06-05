<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

Route::view('/welcome', 'welcome');


Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'register_page'])->name('register');
    Route::get('/login', [AuthController::class, 'login_page'])->name('login');
});


Route::group([], function () {
    Route::resource('project', ProjectController::class);
    Route::resource('project.task', TaskController::class);
});