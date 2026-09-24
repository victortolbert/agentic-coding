<?php

use App\Http\Controllers\BoardPinsController;
use App\Http\Controllers\BoardsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('boards', BoardsController::class);

    Route::resource('boards.pins', BoardPinsController::class)
        ->only(['store', 'update', 'destroy'])
        ->shallow();
});
