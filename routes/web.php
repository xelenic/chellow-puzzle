<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

Route::get('/', function () {
    return view('game');
});

Route::post('/player/start',  [PlayerController::class, 'start']);
Route::post('/player/result', [PlayerController::class, 'result']);
