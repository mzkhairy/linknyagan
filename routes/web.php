<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageNameController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\pageSettingsController;
use App\Http\Controllers\PublicPageController;

Route::get('/check-page-name/{pageName}', [PageNameController::class, 'checkAvailability']);

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('welcome');
    })->name('login');
    
    Route::get('/register', function () {
        return view('welcome');
    })->name('register');
    
    Route::get('/forgot-password', function () {
        return view('welcome');
    })->name('password.request');
    
    Route::get('/reset-password/{token}', function () {
        return view('welcome');
    })->name('password.reset');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/links', [LinkController::class, 'store'])->name('links.store');
    Route::patch('/links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');

    Route::patch('/pageSettings', [pageSettingsController::class, 'updatePgDescription'])->name('page.update.description');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{pageName}', [PublicPageController::class, 'show'])->name('publicview');
require __DIR__.'/auth.php';
