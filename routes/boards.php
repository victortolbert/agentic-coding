<?php

use App\Http\Controllers\BoardPinsController;
use App\Http\Controllers\BoardsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('boards', BoardsController::class);
    Route::post('boards/{board}/share', [BoardsController::class, 'share'])->name('boards.share');
    Route::delete('boards/{board}/share', [BoardsController::class, 'unshare'])->name('boards.unshare');

    Route::resource('boards.pins', BoardPinsController::class)
        ->only(['store', 'update', 'destroy'])
        ->shallow();
});

Route::get('boards/{board}/public', [BoardsController::class, 'public'])->name('boards.public');
