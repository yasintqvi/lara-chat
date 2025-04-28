<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMessageController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserLogoutController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {

    Route::post('/register', UserRegisterController::class)->name('auth.register');

    Route::post('/login', UserLoginController::class)->name('auth.login');

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('user', fn() => UserResource::make(user()))->name('auth.user');

        Route::post('/logout', UserLogoutController::class)->name('auth.logout');
    });
});

Route::prefix('groups')->middleware('auth:sanctum')->group(function () {

    Route::get('/', [GroupController::class, 'index'])->name('groups.index');

    Route::get('/{group}', [GroupController::class, 'show'])->name('groups.show');

    Route::post('/', [GroupController::class, 'store'])->name('groups.store');

    Route::put('/{group}', [GroupController::class, 'update'])->name('groups.store');

    Route::delete('/{group}', [GroupController::class, 'destroy'])->name('groups.delete');

    Route::get('/{group}/messages', [GroupMessageController::class, 'index'])->name('groups.messages.index');

    Route::post('/{group}/messages', [GroupMessageController::class, 'store'])->name('groups.messages.store');

    Route::delete('/{group}/messages/{message}', [GroupMessageController::class, 'destroy'])->name('groups.messages.delete');
});
