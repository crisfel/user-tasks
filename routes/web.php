<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = Auth::user();
    if (isset($user)) {
        return view('home');
    }
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', App\Http\Controllers\User\ShowAllViewController::class)->name('user.index');
Route::get('/tasks', App\Http\Controllers\Task\ShowAllViewController::class)->name('task.index');


