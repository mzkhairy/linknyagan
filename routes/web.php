<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageNameController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PublicPageController;

Route::get('/check-page-name/{pageName}', [PageNameController::class, 'checkAvailability']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('welcome');
})->middleware('guest')->name('register');

Route::get('/login', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/forgot-password', function () {
    return view('welcome');
})->middleware('guest')->name('password.request');

Route::get('/reset-password/{token}', function () {
    return view('welcome');
})->middleware('guest')->name('password.reset');    

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/links', function () {
        return Auth::user()->links;
    })->name('links.index');
    
    Route::post('/links', [LinkController::class, 'store'])->name('links.store');
    Route::get('/links/{link}/edit', [LinkController::class, 'edit'])->name('links.edit');
    Route::patch('/links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
    Route::post('/links/reorder', [LinkController::class, 'reorder']);
});
require __DIR__.'/auth.php';
