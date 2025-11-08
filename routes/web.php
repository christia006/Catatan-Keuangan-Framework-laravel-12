<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// ========================
// ROOT REDIRECT
// ========================
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('app.home');
    }
    return redirect()->route('auth.login');
})->name('home');

// ========================
// AUTH ROUTES
// ========================
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// ========================
// APP ROUTES (Hanya untuk user login)
// ========================
Route::prefix('app')->middleware('auth')->name('app.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/todos/{todo_id}', [HomeController::class, 'todoDetail'])->name('todos.detail');
});

// ========================
// 404 FALLBACK
// ========================
Route::fallback(function () {
    if (Auth::check()) {
        return redirect()->route('app.home');
    }
    return redirect()->route('auth.login');
});