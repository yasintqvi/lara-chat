<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMessageController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('groups')->group(function () {

    Route::get('/', [GroupController::class, 'index'])->name('groups.index');

    Route::get('/{group}', [GroupController::class, 'show'])->name('groups.show');

    Route::post('/', [GroupController::class, 'store'])->name('groups.store');

    Route::put('/{group}', [GroupController::class, 'update'])->name('groups.store');

    Route::delete('/{group}', [GroupController::class, 'destroy'])->name('groups.delete');

    Route::get('/{group}/messages', [GroupMessageController::class, 'index'])->name('groups.messages.index');

    Route::post('/{group}/messages', [GroupMessageController::class, 'store'])->name('groups.messages.store');

    Route::delete('/{group}/messages/{message}', [GroupMessageController::class, 'destroy'])->name('groups.messages.delete');
});
