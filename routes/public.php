<?php

use App\Http\Controllers\Public\EntranceController;

Route::get('/', [EntranceController::class, 'index'])->name('homepage');