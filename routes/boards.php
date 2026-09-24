<?php

use App\Http\Controllers\BoardPinsController;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\PublicBoardsController;
use App\Http\Controllers\SharedBoardsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('boards', BoardsController::class);

    Route::resource('boards.pins', BoardPinsController::class)
        ->only(['store', 'update', 'destroy'])
        ->shallow();

    Route::post('shared-boards', [SharedBoardsController::class, 'store'])->name('shared-boards.store');
    Route::delete('shared-boards/{board}', [SharedBoardsController::class, 'destroy'])->name('shared-boards.destroy');
});

Route::get('b/{board:share_token}', [PublicBoardsController::class, 'show'])->name('public-boards.show');
