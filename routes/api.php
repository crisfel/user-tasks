<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('v1/user/store', App\Http\Controllers\User\StoreController::class)->name('user.store');
Route::put('v1/user/update', App\Http\Controllers\User\UpdateController::class)->name('user.update');
Route::delete('v1/user/{id}', App\Http\Controllers\User\DeleteController::class)->name('user.delete');
Route::get('v1/users', App\Http\Controllers\User\ShowAllController::class)->name('user.show-all');
Route::get('v1/user/{id}', App\Http\Controllers\User\ShowByIDController::class)->name('user.show-by-id');


Route::post('v1/task/store', App\Http\Controllers\Task\StoreController::class)->name('task.store');
Route::put('v1/task/update', App\Http\Controllers\Task\UpdateController::class)->name('task.update');

Route::get('v1/tasks', App\Http\Controllers\Task\ShowAllController::class)->name('task.show-all');
Route::delete('v1/task/{id}', App\Http\Controllers\Task\DeleteController::class)->name('task.delete');

Route::get('v1/user-task/{userID}', App\Http\Controllers\UserTask\ShowByUserIDController::class)->name('user-task.show-by-user-id');
Route::post('v1/user-task/change-status', App\Http\Controllers\UserTask\ChangeStatusController::class)->name('user-task.change-status');

