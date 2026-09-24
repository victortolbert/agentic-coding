<?php

use App\Http\Controllers\BoardsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('boards', BoardsController::class)->only(['index']);
});
