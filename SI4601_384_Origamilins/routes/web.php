<?php

use App\Http\Controllers\Produk_Controller;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;

// Halaman welcome
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Test route untuk admin middleware
Route::get('/test-admin', function() {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    $user = auth()->user();
    return "Logged in as: {$user->name} (Role: {$user->role})";
})->middleware('auth')->middleware(AdminMiddleware::class);

// Route untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
});
