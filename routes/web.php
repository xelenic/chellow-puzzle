<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('game');
});

Route::post('/player/start',  [PlayerController::class, 'start']);
Route::post('/player/result', [PlayerController::class, 'result']);

// Admin panel
Route::get ('/admin',          [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get ('/admin/login',    [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login',    [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',   [AdminController::class, 'logout'])->name('admin.logout');
