<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

//Open routes
Route::post('register', [AuthController::class, 'register'])->name('api.register');
Route::post('login', [AuthController::class, 'login'])->name('api.login');
Route::get('send_email', [AuthController::class, 'send_email'])->name('api.send_email');

//Protected routes
Route::group(['middleware'=>'auth:api'], function () {
    Route::get('profile', [AuthController::class, 'profile'])->name('api.profile');
    Route::get('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('notifications', [AuthController::class, 'get_notifications'])->name('api.notifications');
    Route::group(['prefix' => 'project'], function () {
        Route::get('/', [ProjectController::class, 'getProjectsAPI'])->name('api.project.index');
        Route::post('/', [ProjectController::class, 'createProjectAPI'])->name('api.project.store');
        Route::get('/{project}', [ProjectController::class, 'getProjectAPI'])->name('api.project.show');
        Route::put('/{project}', [ProjectController::class, 'updateProjectAPI'])->name('api.project.update');
        Route::delete('/{project}', [ProjectController::class, 'destroyProjectAPI'])->name('api.project.destroy');
        Route::group(['prefix' => '/{project}/task'], function () {
            Route::get('/', [TaskController::class, 'getTasksAPI'])->name('api.task.index');
            Route::post('/', [TaskController::class, 'createTaskAPI'])->name('api.task.store');
            Route::get('/{task}', [TaskController::class, 'getTaskAPI'])->name('api.task.show');
            Route::put('/{task}', [TaskController::class, 'updateTaskAPI'])->name('api.task.update');
            Route::delete('/{task}', [TaskController::class, 'destroyTaskAPI'])->name('api.task.destroy');
        });
    });
});

